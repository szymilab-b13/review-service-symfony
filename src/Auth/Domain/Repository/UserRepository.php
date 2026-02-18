<?php declare(strict_types=1);

namespace App\Auth\Domain\Repository;

use App\Auth\Domain\Entity\User;
use App\Auth\Domain\ValueObject\Email;
use App\Shared\Domain\ValueObject\UserId;

/**
 * Interface UserRepository
 * @package App\Auth\Domain\Repository
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
interface UserRepository
{
    public function save(User $user): void;

    public function findById(UserId $id): ?User;

    public function findByEmail(Email $email): ?User;

    public function existsByEmail(Email $email): bool;
}
 