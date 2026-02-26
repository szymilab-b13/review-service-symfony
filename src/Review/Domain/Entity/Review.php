<?php declare(strict_types=1);

namespace App\Review\Domain\Entity;

use App\Review\Domain\Enum\ReviewStatus;
use App\Review\Domain\Exception\InvalidStatusTransitionException;
use App\Review\Domain\ValueObject\CommentId;
use App\Review\Domain\ValueObject\ProductSku;
use App\Review\Domain\ValueObject\Rating;
use App\Review\Domain\ValueObject\ReviewId;
use App\Review\Domain\ValueObject\TenantId;
use App\Shared\Domain\ValueObject\UserId;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Class Review
 * @package App\Review\Domain\Entity
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
final class Review
{
    private ReviewStatus $status;
    private ?string $rejectionReason = null;
    private ?UserId $moderatorId = null;
    private ?\DateTimeImmutable $moderatedAt = null;
    private Collection $comments;

    /**
     * @param ReviewId $id
     * @param TenantId $tenantId
     * @param ProductSku $productSku
     * @param Rating $rating
     * @param string $title
     * @param string $body
     * @param string $authorName
     * @param UserId $authorId
     * @param array $tags
     * @param \DateTimeImmutable $createdAt
     */
    private function __construct(
        private ReviewId           $id,
        private TenantId           $tenantId,
        private ProductSku         $productSku,
        private Rating             $rating,
        private string             $title,
        private string             $body,
        private string             $authorName,
        private UserId             $authorId,
        private array              $tags,
        private \DateTimeImmutable $createdAt,
    )
    {
        $this->status   = ReviewStatus::PENDING;
        $this->comments = new ArrayCollection();
    }

    public static function create(
        ReviewId   $id,
        TenantId   $tenantId,
        ProductSku $productSku,
        Rating     $rating,
        string     $title,
        string     $body,
        string     $authorName,
        UserId     $authorId,
        array      $tags = [],
    ): self
    {
        return new self(
            $id,
            $tenantId,
            $productSku,
            $rating,
            $title,
            $body,
            $authorName,
            $authorId,
            $tags,
            new \DateTimeImmutable());
    }

    public function id(): ReviewId
    {
        return $this->id;
    }

    public function tenantId(): TenantId
    {
        return $this->tenantId;
    }

    public function productSku(): ProductSku
    {
        return $this->productSku;
    }

    public function rating(): Rating
    {
        return $this->rating;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function body(): string
    {
        return $this->body;
    }

    public function authorName(): string
    {
        return $this->authorName;
    }

    public function authorId(): UserId
    {
        return $this->authorId;
    }

    public function status(): ReviewStatus
    {
        return $this->status;
    }

    public function rejectionReason(): ?string
    {
        return $this->rejectionReason;
    }

    public function moderatorId(): ?UserId
    {
        return $this->moderatorId;
    }

    public function moderatedAt(): ?\DateTimeImmutable
    {
        return $this->moderatedAt;
    }

    /**
     * @return string[]
     */
    public function tags(): array
    {
        return $this->tags;
    }

    public function createdAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /** @return Collection<int, ReviewComment> */
    public function comments(): Collection
    {
        return $this->comments;
    }

    public function addComment(
        CommentId $commentId,
        UserId    $authorId,
        string    $authorName,
        string    $content,
    ): ReviewComment {
        $comment = ReviewComment::create(
            $commentId,
            $this,
            $authorId,
            $authorName,
            $content,
        );
        $this->comments->add($comment);

        return $comment;
    }

    private function changeStatus(ReviewStatus $newStatus): void
    {
        if (!$this->status->canTransitionTo($newStatus)) {
            throw InvalidStatusTransitionException::create($this->status, $newStatus);
        }
        $this->status = $newStatus;
    }

    public function approve(UserId $moderatorId): void
    {
        $this->changeStatus(ReviewStatus::APPROVED);
        $this->moderatorId = $moderatorId;
        $this->moderatedAt = new \DateTimeImmutable();
    }

    public function reject(UserId $moderatorId, string $reason): void
    {
        $this->changeStatus(ReviewStatus::REJECTED);
        $this->moderatorId      = $moderatorId;
        $this->rejectionReason  = $reason;
        $this->moderatedAt      = new \DateTimeImmutable();
    }
}
 