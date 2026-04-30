<?php

namespace App\Controller;

use App\Entity\PortalDocument;
use App\Entity\PortalNotification;
use App\Entity\User;
use App\Repository\PortalDocumentRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Knp\Component\Pager\PaginatorInterface;
use setasign\Fpdi\Fpdi;
use App\Service\AccessHelper;

class PortalDocumentController extends AbstractController
{
    private AccessHelper $access;

    public function __construct(AccessHelper $access)
    {
        $this->access = $access;
    }

    #[Route('/rh/documents', name: 'app_rh_documents')]
    public function index(PortalDocumentRepository $docRepo, UserRepository $userRepo, PaginatorInterface $paginator, Request $request): Response
    {
        if (!$this->access->canView('rh_documents')) {
            throw $this->createAccessDeniedException();
        }
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        
        $magasinFilter = $request->query->get('magasin');
        $employeeFilter = $request->query->get('employee');

        $queryBuilder = $docRepo->createQueryBuilder('d')
            ->leftJoin('d.targetUser', 'tu')
            ->orderBy('d.uploadedAt', 'DESC');

        if ($this->access->canEdit('rh_documents') || $this->access->isFullView('rh_documents')) {
            $queryBuilder->where('d.type != :global')
                ->setParameter('global', 'GLOBAL');
            
            if ($this->access->isMagasinOnly('rh_documents')) {
                $queryBuilder->andWhere('tu.magasin = :my_mag')
                    ->setParameter('my_mag', $currentUser->getMagasin());
            } elseif ($magasinFilter) {
                $queryBuilder->andWhere('tu.magasin = :magasin')
                    ->setParameter('magasin', $magasinFilter);
            }
            if ($employeeFilter) {
                $queryBuilder->andWhere('tu.id = :empId')
                    ->setParameter('empId', $employeeFilter);
            }

            // Get list of magasins excluding 'Client'
            $magasinsQb = $userRepo->createQueryBuilder('u')
                ->select('DISTINCT u.magasin')
                ->where('u.magasin IS NOT NULL')
                ->andWhere("u.magasin != 'Client'")
                ->orderBy('u.magasin', 'ASC');

            if ($this->access->isMagasinOnly('rh_documents')) {
                $magasinsQb->andWhere('u.magasin = :my_mag')
                    ->setParameter('my_mag', $currentUser->getMagasin());
            }

            $magasins = array_map(fn($m) => $m['magasin'], $magasinsQb->getQuery()->getResult());

            // Get ALL team members (Employees, Responsables, Admins) but no Clients
            $employesQb = $userRepo->createQueryBuilder('u')
                ->where("u.magasin != 'Client' AND u.magasin IS NOT NULL")
                ->orderBy('u.nom', 'ASC');

            if ($this->access->isMagasinOnly('rh_documents')) {
                $employesQb->andWhere('u.magasin = :my_mag')
                    ->setParameter('my_mag', $currentUser->getMagasin());
            }
            
            $employes = $employesQb->getQuery()->getResult();
            
            // "Latest documents that needs review" (Pending signature)
            $pendingDocs = $docRepo->findBy(
                ['status' => 'PENDING_SIGNATURE'],
                ['uploadedAt' => 'DESC'],
                10
            );

        } else {
            $queryBuilder->where('d.targetUser = :user OR d.sender = :user')
                ->setParameter('user', $currentUser);
            $employes = [];
            $magasins = [];
            $pendingDocs = [];
        }

        $pagination = $paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('rh/documents.html.twig', [
            'pagination' => $pagination,
            'employes' => $employes,
            'magasins' => $magasins,
            'currentMagasin' => $magasinFilter,
            'currentEmployee' => $employeeFilter,
            'pendingDocuments' => $pendingDocs,
            'canEdit' => $this->access->canEdit('rh_documents'),
            'isFullAccess' => $this->access->isFullAccess('rh_documents'),
        ]);
    }

    #[Route('/rh/documents/save-director-signature', name: 'app_rh_document_save_director_signature', methods: ['POST'])]
    public function saveDirectorSignature(Request $request, EntityManagerInterface $em): Response
    {
        if (!$this->access->canEdit('rh_documents')) {
            throw $this->createAccessDeniedException();
        }
        /** @var User $user */
        $user = $this->getUser();
        
        $signature = $request->request->get('signature');
        if ($signature) {
            $user->setSignature($signature);
            $em->persist($user);
            $em->flush();
            return $this->json(['success' => true]);
        }
        
        return $this->json(['success' => false, 'message' => 'Signature manquante']);
    }

    #[Route('/rh/documents/send', name: 'app_rh_document_send', methods: ['POST'])]
    public function sendDocument(Request $request, EntityManagerInterface $em, SluggerInterface $slugger, UserRepository $userRepo): Response
    {
        if (!$this->access->canEdit('rh_documents')) {
            throw $this->createAccessDeniedException();
        }
        /** @var User $user */
        $user = $this->getUser();
        
        /** @var UploadedFile $file */
        $file = $request->files->get('file');
        $targetUserId = $request->request->get('target_user_id');
        $title = $request->request->get('title');
        $message = $request->request->get('message');
        $type = $request->request->get('type', 'EMPLOYEE_DOC'); // CONTRACT or EMPLOYEE_DOC

        if ($file) {
            $targetUser = $targetUserId ? $userRepo->find($targetUserId) : null;
            
            $ext = strtolower($file->guessExtension() ?? '');
            if ($type === 'CONTRACT' && $ext !== 'pdf') {
                $this->addFlash('error', 'Les contrats à signer doivent obligatoirement être au format PDF.');
                return $this->redirectToRoute('app_rh_documents');
            }
            
            // Magasin check
            if ($targetUser && $this->access->isMagasinOnly('rh_documents') && $targetUser->getMagasin() !== $user->getMagasin()) {
                throw $this->createAccessDeniedException('Vous ne pouvez envoyer des documents qu\'aux employés de votre magasin.');
            }
            
            // Define subfolder structure: Magasin / FirstnameLASTNAME / [Contracts|Documents]
            $magasin = $targetUser ? ($targetUser->getMagasin() ?: 'Inconnu') : 'General';
            $employeeName = $targetUser ? (ucfirst(strtolower($targetUser->getPrenom())) . strtoupper($targetUser->getNom())) : 'Usage';
            $typeFolder = ($type === 'CONTRACT') ? 'Contracts' : 'Documents';
            
            $subFolder = sprintf('%s/%s/%s/', 
                str_replace(['/', '\\'], '_', $magasin),
                str_replace(['/', '\\'], '_', $employeeName),
                $typeFolder
            );
            $fullTargetDir = $this->getParameter('documents_rh_directory') . '/' . $subFolder;

            // Ensure directory exists
            if (!is_dir($fullTargetDir)) {
                mkdir($fullTargetDir, 0777, true);
            }

            $titleToUse = $title ?: pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $safeTitle = $slugger->slug($titleToUse);
            
            if ($type === 'CONTRACT' && $targetUser) {
                $employeeNameCap = ucfirst(strtolower($targetUser->getPrenom())) . strtoupper($targetUser->getNom());
                $newFilename = $employeeNameCap . '_Contract_' . uniqid() . '.' . $file->guessExtension();
            } else {
                $newFilename = $safeTitle . '_' . uniqid() . '.' . $file->guessExtension();
            }

            try {
                $file->move($fullTargetDir, $newFilename);
            } catch (\Exception $e) {
                $this->addFlash('error', 'Erreur lors de l\'envoi du fichier.');
                return $this->redirectToRoute('app_rh_documents');
            }

            $doc = new PortalDocument();
            $doc->setTitle($title ?: $titleToUse);
            $doc->setFilename($subFolder . $newFilename); // Save RELATIVE path
            $doc->setOriginalFilename($file->getClientOriginalName());
            $doc->setSender($user);
            $doc->setMessage($message);
            $doc->setType($type);
            $doc->setStatus($type === 'CONTRACT' ? 'PENDING_SIGNATURE' : 'NONE');

            if ($targetUser) {
                $doc->setTargetUser($targetUser);
            }

            // --- AUTO-SIGN BY DIRECTOR IF CONTRACT ---
            if ($type === 'CONTRACT' && $user->getSignature()) {
                $docsDir = $this->getParameter('documents_rh_directory') . '/';
                $signedDirRelativeName = $subFolder . 'dir_signed_' . uniqid() . '.pdf';
                $signedDirPath = $docsDir . $signedDirRelativeName;
                
                // Save director base64 to temp PNG
                $sigData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $user->getSignature()));
                $tempSigPath = $docsDir . 'sig_dir_' . uniqid() . '.png';
                file_put_contents($tempSigPath, $sigData);

                // NEW: Use PHP-native signing with multiple blocks support
                $directorName = ($user->getPrenom() ?? '') . ' ' . ($user->getNom() ?? '');
                $dateStr = (new \DateTime())->format('d/m/Y a H:i');
                $directorLabel = $request->request->get('director_label');
                if ($directorLabel === null) {
                    $directorLabel = "Pour l'entreprise,";
                }

                $blocks = [
                    [
                        'path' => $tempSigPath,
                        'name' => $directorName,
                        'date' => $dateStr,
                        'role' => 'director',
                        'header' => $directorLabel
                    ]
                ];

                if ($targetUser) {
                    $blocks[] = [
                        'path' => null,
                        'name' => ($targetUser->getPrenom() ?? '') . ' ' . ($targetUser->getNom() ?? ''),
                        'date' => '',
                        'role' => 'employee',
                        'placeholder' => 'À lire et signer'
                    ];
                }

                try {
                    $success = $this->signPdfWithPhp(
                        $docsDir . $doc->getFilename(),
                        $signedDirPath,
                        $blocks
                    );

                    if ($success && file_exists($signedDirPath) && filesize($signedDirPath) > 100) {
                        @unlink($docsDir . $doc->getFilename());
                        $doc->setFilename($signedDirRelativeName);
                    }
                } catch (\Exception $e) {
                    @unlink($tempSigPath);
                    @unlink($docsDir . $doc->getFilename()); // Delete the unsignable uploaded file
                    $this->addFlash('error', $e->getMessage());
                    return $this->redirectToRoute('app_rh_documents');
                }
                @unlink($tempSigPath);
            }

            $em->persist($doc);
            
            // Create notification for target user
            if ($doc->getTargetUser()) {
                $notif = new PortalNotification();
                $notif->setUser($doc->getTargetUser());
                $notif->setTitle('Nouveau document reçu');
                $notif->setContent($user->getPrenom() . ' vous a envoyé un document : ' . $doc->getTitle());
                $notif->setLink($this->generateUrl('app_rh_documents'));
                $notif->setType('DOCUMENT');
                $em->persist($notif);
            }

            $em->flush();

            $this->addFlash('success', 'Document transmis avec succès.');
        }

        return $this->redirectToRoute('app_rh_documents');
    }

    #[Route('/rh/documents/stream/{id}', name: 'app_rh_document_stream')]
    public function streamDocument(PortalDocument $doc): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        if (!$this->access->canView('rh_documents') && $doc->getTargetUser() !== $user && $doc->getSender() !== $user) {
            throw $this->createAccessDeniedException();
        }

        // Magasin check if restricted view
        if ($this->access->isMagasinOnly('rh_documents') && $doc->getTargetUser() !== $user && $doc->getSender() !== $user) {
            if ($doc->getTargetUser() && $doc->getTargetUser()->getMagasin() !== $user->getMagasin()) {
                 throw $this->createAccessDeniedException();
            }
        }

        $filePath = $this->getParameter('documents_rh_directory') . '/' . $doc->getFilename();
        if (!file_exists($filePath)) {
            throw $this->createNotFoundException('Fichier introuvable.');
        }

        $response = new BinaryFileResponse($filePath);
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_INLINE, $doc->getOriginalFilename());

        return $response;
    }

    #[Route('/rh/documents/sign/{id}', name: 'app_rh_document_sign', methods: ['POST'])]
    public function sign(PortalDocument $doc, Request $request, EntityManagerInterface $em): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        if ($doc->getTargetUser() !== $user || $doc->getType() !== 'CONTRACT') {
            throw $this->createAccessDeniedException();
        }

        $signature = $request->request->get('signature');
        if (!$signature) {
            $this->addFlash('error', 'La signature est obligatoire.');
            return $this->redirectToRoute('app_rh_documents');
        }

        $docsDir = $this->getParameter('documents_rh_directory') . '/';
        $originalFile = $docsDir . $doc->getFilename();

        // Save signature dataURL as temp PNG
        $sigData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $signature));
        $tempSigPath = $docsDir . 'sig_temp_' . uniqid() . '.png';
        file_put_contents($tempSigPath, $sigData);
        $signedFilename = preg_replace('/\.pdf$/i', '', $doc->getFilename()) . '_signed_' . time() . '.pdf';
        $signedFile = $docsDir . $signedFilename;

        try {
            $employeeName = ($user->getPrenom() ?? '') . ' ' . ($user->getNom() ?? '');
            $dateStr = (new \DateTime())->format('d/m/Y a H:i');
            
            $signatureBlocks = [];
            
            // The document is already pre-stamped by the Director during the `sendDocument()` phase
            // (including their custom header and the employee's "À lire et signer" placeholder).
            // We only need to append the new Employee signature now to overwrite the placeholder.

            // 2. Add Employee signature (current user)
            $signatureBlocks[] = [
                'path' => $tempSigPath,
                'name' => $employeeName,
                'date' => $dateStr,
                'role' => 'employee'
            ];
            
            // Generate final PDF with both signatures
            $success = $this->signPdfWithPhp(
                $originalFile,
                $signedFile,
                $signatureBlocks
            );
            
            if (!$success || !file_exists($signedFile) || filesize($signedFile) < 100) {
                throw new \Exception('La génération du PDF a échoué. Le fichier n\'a pas été créé.');
            }

        } catch (\Exception $e) {
            @unlink($tempSigPath);
            $this->addFlash('error', 'Erreur lors de la génération du PDF signé: ' . $e->getMessage());
            return $this->redirectToRoute('app_rh_documents');
        }

        // Cleanup temp sig image
        @unlink($tempSigPath);

        // Persist signature data + update filename to signed PDF
        $oldFilePath = $docsDir . $doc->getFilename();
        
        $doc->setSignature($signature);
        $doc->setSignedAt(new \DateTime());
        $doc->setStatus('SIGNED');
        
        // Update both physical name and the "original name" used for downloads
        $doc->setFilename($signedFilename); 
        $newOriginalName = preg_replace('/\.pdf$/i', '', $doc->getOriginalFilename()) . '_signé.pdf';
        $doc->setOriginalFilename($newOriginalName);
        
        $em->flush();

        // Create notification for the director (sender)
        if ($doc->getSender()) {
            $notif = new PortalNotification();
            $notif->setUser($doc->getSender());
            $notif->setTitle('Contrat signé');
            $notif->setContent($user->getPrenom() . ' ' . $user->getNom() . ' a signé le contrat : ' . $doc->getTitle());
            $notif->setLink($this->generateUrl('app_rh_documents'));
            $notif->setType('DOCUMENT_SIGNED');
            $em->persist($notif);
            $em->flush();
        }

        // Physically delete the original unsigned file as requested ("replace original")
        if (file_exists($oldFilePath) && $oldFilePath !== $signedFile) {
            @unlink($oldFilePath);
        }

        $this->addFlash('success', 'Contrat signé avec succès. Le document original a été remplacé par la version signée.');
        return $this->redirectToRoute('app_rh_documents');
    }

    #[Route('/rh/documents/delete/{id}', name: 'app_rh_document_delete', methods: ['POST'])]
    public function deleteDocument(PortalDocument $doc, EntityManagerInterface $em): Response
    {
        if (!$this->access->canEdit('rh_documents')) {
            throw $this->createAccessDeniedException();
        }

        // Magasin check
        /** @var User $me */
        $me = $this->getUser();
        if ($this->access->isMagasinOnly('rh_documents') && $doc->getTargetUser() && $doc->getTargetUser()->getMagasin() !== $me->getMagasin()) {
            throw $this->createAccessDeniedException();
        }

        $filePath = $this->getParameter('documents_rh_directory') . '/' . $doc->getFilename();

        // Physically delete file if it exists
        if (file_exists($filePath)) {
            @unlink($filePath);
        }

        $em->remove($doc);
        $em->flush();

        $this->addFlash('success', 'Document supprimé avec succès.');
        return $this->redirectToRoute('app_rh_documents');
    }

    #[Route('/rh/documents/fix-python-env', name: 'app_rh_document_fix_python_env')]
    public function fixPythonEnv(): Response
    {
        if (!$this->access->isFullAccess('rh_documents')) {
            throw $this->createAccessDeniedException();
        }
        
        $reqPath = $this->getParameter('kernel.project_dir') . '/scripts/requirements.txt';
        $results = [];
        
        // Try various pip install commands
        $cmds = [
            'python3 -m pip install --user -r ' . escapeshellarg($reqPath) . ' 2>&1',
            'pip3 install --user -r ' . escapeshellarg($reqPath) . ' 2>&1',
            'python -m pip install --user -r ' . escapeshellarg($reqPath) . ' 2>&1',
            'pip install --user -r ' . escapeshellarg($reqPath) . ' 2>&1'
        ];
        
        foreach ($cmds as $cmd) {
            $output = shell_exec($cmd);
            $results[] = [
                'cmd' => $cmd,
                'output' => $output ?: 'Pas de sortie'
            ];
        }
        
        $html = "<h1>Diagnostic & Fix Python</h1>";
        foreach ($results as $res) {
            $html .= sprintf("<h3>Commande: %s</h3><pre>%s</pre><hr>", $res['cmd'], $res['output']);
        }
        $html .= "<p>Si l'une des commandes a réussi, relancez la signature pour tester.</p>";
        
        return new Response($html);
    }

    private function signPdfWithPhp(string $inputPath, string $outputPath, array $signatureBlocks): bool
    {
        $tempUncompressed = null;
        try {
            if (!file_exists($inputPath)) return false;

            $pdf = new Fpdi();
            $pdf->SetAutoPageBreak(false); // Disable auto breaks to prevent shifting
            
            // Try reading the file directly
            try {
                $pageCount = $pdf->setSourceFile($inputPath);
            } catch (\Exception $e) {
                // If it fails due to PDF version/compression, try Ghostscript
                if (strpos(strtolower($e->getMessage()), 'compression') !== false || strpos(strtolower($e->getMessage()), 'parser') !== false) {
                    if (function_exists('shell_exec')) {
                        $isWindows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
                        $gsCmd = $isWindows ? 'gswin64c.exe' : 'gs';
                        $sysCheck = $isWindows ? ('where ' . $gsCmd . ' 2>nul') : ('which ' . $gsCmd . ' 2>/dev/null');
                        
                        $gsPathObj = trim((string)shell_exec($sysCheck));
                        $gsPath = ($isWindows && strpos($gsPathObj, "\r\n") !== false) ? explode("\r\n", $gsPathObj)[0] : $gsPathObj;

                        // Fallback hardcoded search for Windows if not in PATH
                        if ($isWindows && (!$gsPath || !file_exists(trim($gsPath, '"')))) {
                            $matches = glob('C:\\Program Files\\gs\\*\\bin\\gswin64c.exe');
                            if (!empty($matches)) {
                                $gsPath = escapeshellarg($matches[0]);
                            } else {
                                $matches64 = glob('C:\\Program Files (x86)\\gs\\*\\bin\\gswin*c.exe');
                                if (!empty($matches64)) {
                                    $gsPath = escapeshellarg($matches64[0]);
                                }
                            }
                        }

                        if ($gsPath && file_exists(trim($gsPath, "'\""))) {
                            $tempUncompressed = $inputPath . '.v14.pdf';
                            $cmd = sprintf(
                                '%s -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dNOPAUSE -dQUIET -dBATCH -sOutputFile=%s %s 2>%s',
                                escapeshellarg(trim($gsPath, '"')),
                                escapeshellarg($tempUncompressed),
                                escapeshellarg($inputPath),
                                $isWindows ? 'nul' : '/dev/null'
                            );
                            shell_exec($cmd);
                            
                            if (file_exists($tempUncompressed) && filesize($tempUncompressed) > 0) {
                                try {
                                    $pageCount = $pdf->setSourceFile($tempUncompressed);
                                } catch (\Exception $e2) {
                                    throw new \Exception("Ce fichier PDF utilise une compression non gérée. Veuillez l'imprimer en PDF (format 1.4) avant de l'envoyer.");
                                }
                            } else {
                                throw new \Exception("Ce fichier PDF utilise une compression non gérée. Veuillez l'imprimer en PDF (format 1.4) avant de l'envoyer.");
                            }
                        } else {
                            throw new \Exception("Ce fichier PDF utilise une compression non gérée. Veuillez l'imprimer en PDF (format 1.4) avant de l'envoyer.");
                        }
                    } else {
                        throw new \Exception("Ce fichier PDF utilise une compression non gérée. Veuillez l'imprimer en PDF (format 1.4) avant de l'envoyer.");
                    }
                } else {
                    throw $e;
                }
            }
            
            for ($i = 1; $i <= $pageCount; $i++) {
                $templateId = $pdf->importPage($i);
                $size = $pdf->getTemplateSize($templateId);
                
                $pdf->addPage($size['orientation'], [$size['width'], $size['height']]);
                $pdf->useTemplate($templateId);
                
                if ($i === $pageCount) {
                    $pageW = $size['width'];
                    $pageH = $size['height'];
                    
                    foreach ($signatureBlocks as $block) {
                        $sigImagePath = $block['path'];
                        $userName = $block['name'];
                        $dateStr = $block['date'];
                        $role = $block['role'];

                        $sigW = 60;
                        $sigH = 32;
                        $marginX = 25; 
                        $marginY = 10; 
                        
                        if ($role === 'director') {
                            $x = $marginX;
                            $headerText = isset($block['header']) ? $block['header'] : "Pour l'entreprise,";
                            $line1 = $userName;
                            $line2 = "";
                        } else {
                            $x = $pageW - $sigW - $marginX;
                            $headerText = "Le salarié,";
                            $line1 = $userName;
                            $line2 = "";
                        }
                        $y = $pageH - $sigH - $marginY;
                        
                        $pdf->SetDrawColor(199, 206, 210);
                        $pdf->SetFillColor(255, 255, 255);
                        $pdf->Rect($x, $y, $sigW, $sigH, 'DF');
                        
                        $pdf->SetTextColor(15, 23, 41);
                        $pdf->SetFont('Helvetica', 'B', 7);
                        $pdf->SetXY($x + 2, $y + 2);
                        
                        $safeHeaderText = function_exists('mb_convert_encoding') ? mb_convert_encoding($headerText, 'ISO-8859-1', 'UTF-8') : utf8_decode($headerText);
                        $pdf->Cell($sigW - 4, 3, $safeHeaderText, 0, 1);
                        
                        $pdf->SetFont('Helvetica', '', 6);
                        $pdf->SetX($x + 2);
                        $safeLine1 = function_exists('mb_convert_encoding') ? mb_convert_encoding($line1, 'ISO-8859-1', 'UTF-8') : utf8_decode($line1);
                        $pdf->Cell($sigW - 4, 3, $safeLine1, 0, 1);
                        
                        if ($line2) {
                            $pdf->SetFont('Helvetica', '', 5);
                            $pdf->SetX($x + 2);
                            $safeLine2 = function_exists('mb_convert_encoding') ? mb_convert_encoding($line2, 'ISO-8859-1', 'UTF-8') : utf8_decode($line2);
                            $pdf->MultiCell($sigW - 4, 2.8, $safeLine2);
                        }
                        
                        $imgH = ($line2) ? 14 : 18;
                        $imgY = $y + ($line2 ? 9 : 8);
                        
                        if (!empty($block['placeholder'])) {
                            // Render the "À lire et signer" watermark directly where the signature image goes
                            $pdf->SetTextColor(150, 150, 150);
                            $pdf->SetFont('Helvetica', 'B', 10);
                            $pdf->SetXY($x + 2, $imgY + ($imgH / 2) - 2);
                            $safePlaceholder = function_exists('mb_convert_encoding') ? mb_convert_encoding($block['placeholder'], 'ISO-8859-1', 'UTF-8') : utf8_decode($block['placeholder']);
                            $pdf->Cell($sigW - 4, 4, $safePlaceholder, 0, 0, 'C');
                        } elseif ($sigImagePath && file_exists($sigImagePath)) {
                            // Suppress warning if image format is corrupt
                            @$pdf->Image($sigImagePath, $x + 2, $imgY, $sigW - 4, $imgH, 'PNG');
                        }
                        
                        if (!empty($dateStr)) {
                            $pdf->SetTextColor(120, 137, 163);
                            $pdf->SetFont('Helvetica', 'I', 5);
                            $pdf->SetXY($x + 2, $y + $sigH - 4);
                            $dateText = "Signé électroniquement le " . $dateStr;
                            $safeDateText = function_exists('mb_convert_encoding') ? mb_convert_encoding($dateText, 'ISO-8859-1', 'UTF-8') : utf8_decode($dateText);
                            $pdf->Cell($sigW - 4, 3, $safeDateText, 0, 0, 'L');
                        }
                    }
                }
            }
            
            $pdf->Output('F', $outputPath);
            
            if ($tempUncompressed && file_exists($tempUncompressed)) {
                @unlink($tempUncompressed);
            }
            
            return true;
        } catch (\Exception $e) {
            if ($tempUncompressed && file_exists($tempUncompressed)) {
                @unlink($tempUncompressed);
            }
            throw new \Exception($e->getMessage());
        }
    }
}
