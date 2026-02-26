<?php declare(strict_types=1);

namespace App\Review\Application\ReadModel;

/**
 * Class CommentReadModel
 * @package App\Review\Application\ReadModel
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
final readonly class CommentReadModel
{
    public function __construct(
        public string $id,
        public string $authorId,
        public string $authorName,
        public string $content,
        public string $createdAt,
    ) {}
}
 