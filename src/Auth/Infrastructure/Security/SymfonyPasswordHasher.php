<?php declare(strict_types=1);

namespace App\Auth\Infrastructure\Security;


use Symfony\Component\DependencyInjection\Attribute\AsAlias;
use App\Auth\Domain\Port\PasswordHasherInterface;
use App\Auth\Domain\ValueObject\HashedPassword;
use Symfony\Component\PasswordHasher\Hasher\NativePasswordHasher;
use \Symfony\Component\PasswordHasher\PasswordHasherInterface as SymfonyPasswordHasherInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;


/**
 * Class SymfonyPasswordHasher
 * @package App\Auth\Infrastructure\Security
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
#[AsAlias(PasswordHasherInterface::class)]
final readonly class SymfonyPasswordHasher implements PasswordHasherInterface
{
    public function __construct(
        #[Autowire(service: NativePasswordHasher::class)]
        private SymfonyPasswordHasherInterface $hasher,
    ) {
    }

    public function hash(string $plainText): HashedPassword
    {
        return HashedPassword::fromString(
            $this->hasher->hash($plainText)
        );
    }

    public function verify(HashedPassword $hashedPassword, string $plainPassword): bool
    {
        return $this->hasher->verify(
            $hashedPassword->toString(),
            $plainPassword
        );
    }
}
 