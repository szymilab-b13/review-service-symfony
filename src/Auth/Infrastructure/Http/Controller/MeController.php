<?php declare(strict_types=1);

namespace App\Auth\Infrastructure\Http\Controller;

use App\Auth\Infrastructure\Security\SecurityUser;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * Class MeController
 * @package App\Auth\Infrastructure\Http\Controller
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
#[AsController]
final readonly class MeController
{
    #[Route('/api/auth/me', name: 'api_auth_me', methods: ['GET'])]
    public function __invoke(Security $security): JsonResponse
    {
        $user = $security->getUser();

        if (!$user instanceof SecurityUser) {
            throw new \RuntimeException('Unexpected user type');
        }

        return new JsonResponse([
            'id'    => $user->getDomainUser()->id()->value,
            'email' => $user->getUserIdentifier(),
            'roles' => $user->getRoles(),
        ]);
    }
}
 