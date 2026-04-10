<?php

namespace App\EventSubscriber;

use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class SecurityAccessSubscriber implements EventSubscriberInterface
{
    private Security $security;
    private \Twig\Environment $twig;

    public function __construct(Security $security, \Twig\Environment $twig)
    {
        $this->security = $security;
        $this->twig = $twig;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $request = $event->getRequest();
        $route = $request->attributes->get('_route');

        // Allow some routes like login, logout, and static assets
        $allowedRoutes = ['app_login', 'app_logout', '_wdt', '_profiler'];

        if (in_array($route, $allowedRoutes)) {
            return;
        }

        // Check if the path begins with /_ (usually internal/profiler)
        if (str_starts_with($request->getPathInfo(), '/_')) {
            return;
        }

        // If not logged in, redirect to racine
        if (!$this->security->getUser()) {
            $event->setResponse(new \Symfony\Component\HttpFoundation\RedirectResponse('/'));
        }
    }

    public function onKernelException(\Symfony\Component\HttpKernel\Event\ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if (!$exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
            return;
        }

        if (!$this->security->getUser()) {
            $event->setResponse(new \Symfony\Component\HttpFoundation\RedirectResponse('/'));
            return;
        }

        try {
            $content = $this->twig->render('error404.html.twig');
        } catch (\Exception $e) {
            $content = '<h1>404 Not Found</h1><p>La page demandée n\'existe pas.</p>';
        }
        
        $response = new \Symfony\Component\HttpFoundation\Response($content, 404);
        $response->headers->set('Content-Type', 'text/html');
        $event->setResponse($response);
    }

    public static function getSubscribedEvents(): array
    {
        return [
                // Use a low priority to ensure it runs after the firewall listener
            KernelEvents::REQUEST => [['onKernelRequest', 0]],
            KernelEvents::EXCEPTION => [['onKernelException', 0]],
        ];
    }
}


