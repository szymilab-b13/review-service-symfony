<?php declare(strict_types=1);

namespace App\Review\Infrastructure\Doctrine\Repository;

use App\Review\Domain\Entity\Review;
use App\Review\Domain\Exception\ReviewNotFoundException;
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

    /**
     * @param ReviewId $id
     * @return Review
     * @throws ReviewNotFoundException
     */
    public function getById(ReviewId $id): Review
    {
        return $this->findById($id) ?? throw ReviewNotFoundException::withId($id->value);
    }

    /**
     * @param ReviewId $id
     * @return Review
     * @throws ReviewNotFoundException
     */
    public function getByIdWithComments(ReviewId $id): Review
    {
        $review = $this->em->createQueryBuilder()
            ->select('r', 'c')
            ->from(Review::class, 'r')
            ->leftJoin('r.comments', 'c')
            ->where('r.id = :id')
            ->setParameter('id', $id->value)
            ->getQuery()
            ->getOneOrNullResult();

        if ($review === null) {
            throw ReviewNotFoundException::withId($id->value);
        }

        return $review;
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
 