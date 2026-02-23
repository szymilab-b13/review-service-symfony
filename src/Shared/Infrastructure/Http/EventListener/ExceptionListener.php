<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\Http\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class ExceptionListener
 * @package App\Auth\Infrastructure\Http\EventListener
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
#[AsEventListener(event: KernelEvents::EXCEPTION)]
final class ExceptionListener
{
    private const EXCEPTION_MAP = [
        \DomainException::class          => Response::HTTP_CONFLICT,
        \InvalidArgumentException::class => Response::HTTP_BAD_REQUEST,
    ];

    public function __invoke(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof \Symfony\Component\Messenger\Exception\HandlerFailedException) {
            $exception = $exception->getPrevious() ?? $exception;
        }

        foreach (self::EXCEPTION_MAP as $class => $statusCode) {
            if ($exception instanceof $class) {
                $event->setResponse(new JsonResponse(['error' => $exception->getMessage()],$statusCode,));
                return;
            }
        }
    }
}
 