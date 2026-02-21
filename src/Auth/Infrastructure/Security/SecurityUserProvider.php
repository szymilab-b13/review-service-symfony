<?php declare(strict_types=1);

namespace App\Auth\Infrastructure\Security;

use App\Auth\Domain\Repository\UserRepository;
use App\Auth\Domain\ValueObject\Email;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * Class SecurityUserProvider
 * @package App\Auth\Infrastructure\Security
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
final class SecurityUserProvider implements UserProviderInterface
{

    public function __construct(private UserRepository $userRepository)
    {
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        return $this->loadUserByIdentifier($user->getUserIdentifier());
    }

    public function supportsClass(string $class): bool
    {
        return $class === SecurityUser::class;
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        $user = $this->userRepository->findByEmail(Email::fromString($identifier));
        if (!$user) {
            throw new UserNotFoundException();
        }
        return new SecurityUser($user);
    }
}
 