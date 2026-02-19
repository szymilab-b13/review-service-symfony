<?php declare(strict_types=1);

namespace App\Auth\Infrastructure\Http\Controller;

use App\Auth\Application\Command\RegisterCommand;
use App\Auth\Infrastructure\Http\Request\RegisterRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Class RegisterController
 * @package App\Auth\Infrastructure\Http\Controller
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
#[AsController]
final readonly class RegisterController
{
    public function __construct(
        private MessageBusInterface $messageBus,
    ) {
    }

    #[Route('/auth/register', name: 'auth_register', methods: ['POST'])]
    public function __invoke(
        #[MapRequestPayload] RegisterRequest $request,
    ): JsonResponse
    {
        $this->messageBus->dispatch(
            new RegisterCommand(
                email: $request->email,
                plainPassword: $request->password,
            )
        );

        return new JsonResponse(
            ['message' => 'User registered successfully.'],
            Response::HTTP_CREATED,
        );
    }
}
 