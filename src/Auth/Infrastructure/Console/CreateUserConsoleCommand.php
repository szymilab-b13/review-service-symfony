<?php declare(strict_types=1);

namespace App\Auth\Infrastructure\Console;

use App\Auth\Application\Command\RegisterCommand;
use App\Auth\Domain\ValueObject\Role;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Class CreateUserConsoleCommand
 * @package App\Auth\Infrastructure\Console
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */

#[AsCommand(
    name: 'app:user:create',
    description: 'Creates a new user with specified role',
)]
final class CreateUserConsoleCommand extends Command
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io         = new SymfonyStyle($input, $output);
        $email      = $io->ask('Email');
        $password   = $io->askHidden('Password');
        $role       = $io->choice('Role', ['user', 'moderator', 'admin'], 'user');

        $roles = match ($role) {
            'admin'     => [Role::ADMIN->value],
            'moderator' => [Role::MODERATOR->value],
            default     => [Role::USER->value],
        };

        try {
            $this->messageBus->dispatch(
                new RegisterCommand(
                    email: $email,
                    plainPassword: $password,
                    roles: $roles,
                )
            );

            $io->success(sprintf('User "%s" created with role: %s', $email, strtoupper($role)));
        } catch (\Throwable $e) {
            $io->error($e->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
 