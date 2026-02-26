<?php declare(strict_types=1);

namespace App\Review\Domain\Entity;

use App\Review\Domain\ValueObject\CommentId;
use App\Shared\Domain\ValueObject\UserId;

/**
 * Class ReviewComment
 * @package App\Review\Domain\Entity
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
final class ReviewComment
{
    private function __construct(
        private CommentId          $id,
        private Review             $review,
        private UserId             $authorId,
        private string             $authorName,
        private string             $content,
        private \DateTimeImmutable $createdAt,
    ) {

    }

    public static function create(
        CommentId $id,
        Review    $review,
        UserId    $authorId,
        string    $authorName,
        string    $content,
    ): self {
        return new self(
            $id,
            $review,
            $authorId,
            $authorName,
            $content,
            new \DateTimeImmutable(),
        );
    }

    public function id(): CommentId
    {
        return $this->id;
    }

    public function review(): Review
    {
        return $this->review;
    }

    public function authorId(): UserId
    {
        return $this->authorId;
    }

    public function authorName(): string
    {
        return $this->authorName;
    }

    public function content(): string
    {
        return $this->content;
    }

    public function createdAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
 