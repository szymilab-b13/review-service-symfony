<?php declare(strict_types=1);

namespace App\Auth\Application\Command;

/**
 * Class RegisterCommand
 * @package App\Auth\Application\Command
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
final readonly class RegisterCommand
{
    public function __construct(
        public string $email,
        public string $plainPassword,
        public array $roles = [],
    ) {
    }
}
 