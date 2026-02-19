<?php declare(strict_types=1);

namespace App\Auth\Infrastructure\Http\Request;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class RegisterRequest
 * @package App\Auth\Infrastructure\Http\Request
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
final readonly class RegisterRequest
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Email]
        public string $email = '',

        #[Assert\NotBlank]
        #[Assert\Length(min: 8)]
        public string $password = '',
    ) {}
}
 