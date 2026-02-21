<?php declare(strict_types=1);

namespace App\Auth\Domain\Port;

use App\Auth\Domain\ValueObject\HashedPassword;

/**
 * Interface PasswordHasherInterface
 * @package App\Auth\Domain\Port
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
interface PasswordHasherInterface
{
    public function hash(string $plainText): HashedPassword;

    public function verify(HashedPassword $hashedPassword, string $plainPassword): bool;
}