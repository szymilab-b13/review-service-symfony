<?php declare(strict_types=1);

namespace App\Review\Application\Command;

/**
 * Class CreateReviewCommand
 * @package App\Review\Application\Command
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
final readonly class CreateReviewCommand
{
    /**
     * @param string $reviewId
     * @param string $tenantId
     * @param string $productSku
     * @param int $rating
     * @param string $title
     * @param string $body
     * @param string $authorName
     * @param array|string[] $tags
     */
    public function __construct(
        public string $reviewId,
        public string $tenantId,
        public string $productSku,
        public int $rating,
        public string $title,
        public string $body,
        public string $authorName,
        public string $authorId,
        public array $tags = [],
    ) {}
}
 