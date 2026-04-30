<?php



namespace App\Form;



use App\Entity\PortalDocument;

use App\Entity\PortalDocumentFolder;

use App\Entity\Role;

use App\Repository\RoleRepository;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\Form\Extension\Core\Type\FileType;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints\File;



class PortalDocumentType extends AbstractType

{

    private RoleRepository $roleRepository;



    public function __construct(RoleRepository $roleRepository)

    {

        $this->roleRepository = $roleRepository;

    }



    public function buildForm(FormBuilderInterface $builder, array $options): void

    {

        $builder

            ->add('title', TextType::class, [

                'label' => 'Titre',

                'attr' => ['class' => 'w-full px-3 py-2 border border-slate-300 rounded-lg outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500']

            ])

            ->add('folder', \Symfony\Bridge\Doctrine\Form\Type\EntityType::class, [

                'class' => \App\Entity\PortalDocumentFolder::class,

                'choice_label' => 'name',

                'label' => 'Dossier',

                'attr' => ['class' => 'w-full px-3 py-2 border border-slate-300 rounded-lg outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 bg-white']

            ])

            ->add('description', TextareaType::class, [

                'label' => 'Description',

                'required' => false,

                'attr' => ['class' => 'w-full px-3 py-2 border border-slate-300 rounded-lg outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500', 'rows' => 3]

            ])

            ->add('file', FileType::class, [

                'label' => 'Document (PDF, Word, Images)',

                'mapped' => false,

                'required' => $options['require_file'],

                'constraints' => [

                    new File([

                        'maxSize' => '10M',

                        'mimeTypes' => [

                            'application/pdf',

                            'application/x-pdf',

                            'application/msword',

                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',

                            'image/jpeg',

                            'image/png',

                            'image/gif',

                            'image/webp',

                        ],

                        'mimeTypesMessage' => 'Veuillez uploader un document valide (PDF, Word ou Image)',

                    ])

                ],

                'attr' => ['class' => 'block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100']

            ])

            ->add('rolesPermitted', ChoiceType::class, [

                'label' => 'Visible par les rôles',

                'choices' => $this->getRoleChoices(),

                'multiple' => true,

                'expanded' => true,

                'required' => false,

                'attr' => ['class' => 'flex gap-4 flex-wrap'],

            ])

        ;

    }



    public function configureOptions(OptionsResolver $resolver): void

    {

        $resolver->setDefaults([

            'data_class' => PortalDocument::class,

            'require_file' => true,

        ]);

    }



    private function getRoleChoices(): array

    {

        $roles = $this->roleRepository->findAllOrdered();

        $choices = [];

        foreach ($roles as $role) {

            $choices[$role->getLabel()] = $role->getName();

        }

        return $choices;

    }

}
