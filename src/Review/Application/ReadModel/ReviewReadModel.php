<?php declare(strict_types=1);

namespace App\Review\Application\ReadModel;

/**
 * Class ReviewReadModel
 * @package App\Review\Application\ReadModel
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
final readonly class ReviewReadModel
{
    /**
     * @param string[] $tags
     */
    public function __construct(
        public string $id,
        public string $tenantId,
        public string $productSku,
        public int $rating,
        public string $title,
        public string $body,
        public string $authorName,
        public string $authorId,
        public string $status,
        public ?string $rejectionReason,
        public ?string $moderatorId,
        public ?string $moderatedAt,
        public array $tags,
        public string $createdAt,
        public array $comments = [],
    ) {}
}
 