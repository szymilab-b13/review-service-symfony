<?php declare(strict_types=1);

namespace App\Review\Application\Command;

/**
 * Class AddCommentCommand
 * @package App\Review\Application\Command
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
class AddCommentCommand
{
    public function __construct(
        public string $commentId,
        public string $reviewId,
        public string $authorId,
        public string $authorName,
        public string $content,
    ) {}
}
 