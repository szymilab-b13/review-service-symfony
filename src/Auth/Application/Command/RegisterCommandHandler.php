<?php declare(strict_types=1);

namespace App\Auth\Application\Command;


use App\Auth\Domain\Entity\User;
use App\Auth\Domain\Exception\UserAlreadyExistsException;
use App\Auth\Domain\Port\PasswordHasherInterface;
use App\Auth\Domain\Repository\UserRepository;
use App\Auth\Domain\ValueObject\Email;
use App\Auth\Domain\ValueObject\Role;
use App\Shared\Domain\ValueObject\UserId;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

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
        private PasswordHasherInterface $passwordHasher,
    ) {
    }

    public function __invoke(RegisterCommand $command): void
    {
        $email = Email::fromString($command->email);

        if ($this->userRepository->existsByEmail($email)) {
            throw new UserAlreadyExistsException($email);
        }

        $user = User::register(
            id: UserId::generate(),
            email: $email,
            hashedPassword: $this->passwordHasher->hash($command->plainPassword),
            roles: Role::fromStringList($command->roles),
        );

        $this->userRepository->save($user);
    }
}
 