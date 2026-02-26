<?php declare(strict_types=1);

namespace App\Auth\Domain\Entity;

use App\Auth\Domain\ValueObject\Email;
use App\Auth\Domain\ValueObject\HashedPassword;
use App\Auth\Domain\ValueObject\Role;
use App\Shared\Domain\ValueObject\UserId;

/**
 * Class User
 * @package App\Auth\Domain\Entity
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
final class User
{
    private function __construct(
        private UserId $id,
        private Email $email,
        private HashedPassword $hashedPassword,
        private array $roles,
        private \DateTimeImmutable $createdAt,
    )
    {
    }

    public static function register(
        UserId $id,
        Email $email,
        HashedPassword $hashedPassword,
        array $roles = [Role::USER],
    ): self
    {
        return new self(
            id: $id,
            email: $email,
            hashedPassword: $hashedPassword,
            roles: $roles,
            createdAt: new \DateTimeImmutable(),
        );
    }

    public function id(): UserId
    {
        return  $this->id;
    }

    public function email():Email
    {
        return $this->email;
    }

    public function hashedPassword(): HashedPassword
    {
        return $this->hashedPassword;
    }

    public function roles(): array
    {
        return array_map(fn(Role $role) => $role->value, $this->roles);
    }

    public function createdAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
 