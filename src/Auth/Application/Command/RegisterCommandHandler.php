<?php declare(strict_types=1);

namespace App\Auth\Application\Command;


use App\Auth\Domain\Entity\User;
use App\Auth\Domain\Repository\UserRepository;
use App\Auth\Domain\ValueObject\Email;
use App\Shared\Domain\ValueObject\UserId;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Class RegisterCommandHandler
 * @package App\Auth\Application\Command
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
#[AsMessageHandler]
final readonly class RegisterCommandHandler
{
    public function __construct(
        private UserRepository $userRepository,
        private UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function __invoke(RegisterCommand $command): void
    {
        $email = Email::fromString($command->email);

        if ($this->userRepository->existsByEmail($email)) {
            throw new \DomainException('User with this email already exists.');
        }

        $user = User::register(
            id: UserId::generate(),
            email: $email,
            hashedPassword: $command->plainPassword,
        );

        $this->userRepository->save($user);
    }
}
 