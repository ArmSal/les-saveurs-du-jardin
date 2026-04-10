<?php

namespace App\EventSubscriber;

use Doctrine\DBAL\Exception\ConnectionException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;

class DatabaseExceptionSubscriber implements EventSubscriberInterface
{
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => ['onKernelException', 10],
        ];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        // Check if it's a database connection error
        // We look for ConnectionException or specific messages/codes if needed
        if ($exception instanceof ConnectionException || 
            str_contains($exception->getMessage(), 'SQLSTATE[HY000] [2002]') ||
            str_contains($exception->getMessage(), 'ConnectionException')
        ) {
            try {
                $content = $this->twig->render('exception/database_error.html.twig');
                $response = new Response($content, Response::HTTP_SERVICE_UNAVAILABLE);
                $event->setResponse($response);
            } catch (\Exception $e) {
                // If twig fails (e.g. template not found), let the default handler take over
                return;
            }
        }
    }
}
