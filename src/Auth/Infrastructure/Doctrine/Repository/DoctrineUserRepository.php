<?php declare(strict_types=1);

namespace App\Auth\Infrastructure\Doctrine\Repository;

use App\Auth\Domain\Entity\User;
use App\Auth\Domain\Repository\UserRepository;
use App\Auth\Domain\ValueObject\Email;
use App\Shared\Domain\ValueObject\UserId;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;

/**
 * Class DoctrineUserRepository
 * @package App\Auth\Infrastructure\Doctrine\Repository
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */

#[AsAlias(UserRepository::class)]
final readonly class DoctrineUserRepository implements UserRepository
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ){

    }

    public function save(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function findById(UserId $id): ?User
    {
        return $this->entityManager->find(User::class, $id->value);
    }

    public function findByEmail(Email $email): ?User
    {
        return $this->entityManager->getRepository(User::class)
            ->findOneBy(['email' => $email->value]);
    }

    public function existsByEmail(Email $email): bool
    {
        return $this->findByEmail($email) !== null;
    }
}
 