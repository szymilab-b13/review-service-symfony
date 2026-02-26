<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\Security;

use App\Shared\Application\Port\CurrentUserIdResolverInterface;
use App\Shared\Application\Port\IdentifiableUserInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Authenticator\Token\JWTPostAuthenticationToken;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * Class JwtCurrentUserIdResolver
 * @package App\Shared\Security
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
class JwtCurrentUserIdResolver implements CurrentUserIdResolverInterface
{
    public function __construct(
        private Security $security,
    ) {}

    public function resolve(): string
    {
        $user = $this->security->getUser();

        if (!$user instanceof IdentifiableUserInterface) {
            throw new \RuntimeException('No authenticated user.');
        }

        return $user->userId();
    }
}
 