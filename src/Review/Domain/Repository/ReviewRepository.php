<?php declare(strict_types=1);

namespace App\Review\Domain\Repository;

use App\Review\Domain\Entity\Review;
use App\Review\Domain\Exception\ReviewNotFoundException;
use App\Review\Domain\ValueObject\ProductSku;
use App\Review\Domain\ValueObject\ReviewId;

/**
 * Interface ReviewRepository
 * @package App\Review\Domain\Repository
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
interface ReviewRepository
{
    public function save(Review $review): void;

    public function findById(ReviewId $id): ?Review;

    /**
     * @param ReviewId $id
     * @return Review
     * @throws ReviewNotFoundException
     */
    public function getById(ReviewId $id): Review;

    /** @return Review[] */
    public function findByProductSku(ProductSku $sku): array;

    /** @return Review[] */
    public function findByTags(array $tags): array;

    /** @return Review[] */
    public function findAll(): array;
}
 