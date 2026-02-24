<?php declare(strict_types=1);

namespace App\Review\Application\Query;

/**
 * Class GetReviewQuery
 * @package App\Review\Application\Query
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
final readonly class GetReviewQuery
{
    public function __construct(
        public string $reviewId,
    ) {}
}
 