<?php declare(strict_types=1);

namespace App\Review\Infrastructure\Doctrine\Repository;

use App\Review\Domain\Entity\Review;
use App\Review\Domain\Repository\ReviewRepository;
use App\Review\Domain\ValueObject\ProductSku;
use App\Review\Domain\ValueObject\ReviewId;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class DoctrineReviewRepository
 * @package App\Review\Infrastructure\Doctrine\Repository
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
class DoctrineReviewRepository implements ReviewRepository
{
    public function __construct(
        private EntityManagerInterface $em,
    ) {}

    public function save(Review $review): void
    {
        $this->em->persist($review);
        $this->em->flush();
    }

    public function findById(ReviewId $id): ?Review
    {
        return $this->em->find(Review::class, $id->value);
    }

    public function findByProductSku(ProductSku $sku): array
    {
        return $this->em->getRepository(Review::class)
            ->findBy(['productSku' => $sku]);
    }

    public function findByTags(array $tags): array
    {
        // TODO: implement with es or dedicated tags table
        // JSON column search is not efficient for production use

        return [];
    }

    public function findAll(): array
    {
        return $this->em->getRepository(Review::class)->findAll();
    }
}
 