<?php declare(strict_types=1);

namespace App\Auth\Infrastructure\Security;

use App\Auth\Domain\Entity\User;
use App\Shared\Application\Port\IdentifiableUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * Class SecurityUser
 * @package App\Auth\Infrastructure\Security
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
final class SecurityUser implements IdentifiableUserInterface, PasswordAuthenticatedUserInterface
{
    public function __construct(private User $user)
    {

    }

    public function userId(): string
    {
        return (string) $this->user->id();
    }

    public function getRoles(): array
    {
        return $this->user->roles();
    }

    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->user->email()->value;
    }

    public function getPassword(): ?string
    {
        return $this->user->hashedPassword()->toString();
    }

    public function getDomainUser(): User
    {
        return $this->user;
    }
}
 