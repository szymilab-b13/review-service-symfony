<?php declare(strict_types=1);

namespace App\Review\Application\Port;

use App\Review\Domain\Entity\Review;

/**
 * Interface ReviewIndexerInterface
 * @package App\Review\Application\Port
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
interface ReviewIndexerInterface
{
    public function index(Review $review): void;
    public function delete(string $reviewId): void;
}