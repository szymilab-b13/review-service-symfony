<?php declare(strict_types=1);

namespace App\Review\Domain\Entity;

use App\Review\Domain\Enum\ReviewStatus;
use App\Review\Domain\Exception\InvalidStatusTransitionException;
use App\Review\Domain\ValueObject\ProductSku;
use App\Review\Domain\ValueObject\Rating;
use App\Review\Domain\ValueObject\ReviewId;
use App\Review\Domain\ValueObject\TenantId;

/**
 * Class Review
 * @package App\Review\Domain\Entity
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
final class Review
{
    private ReviewStatus $status;
    private ?string $rejectionReason = null;

    /**
     * @param ReviewId $id
     * @param TenantId $tenantId
     * @param ProductSku $productSku
     * @param Rating $rating
     * @param string $title
     * @param string $body
     * @param string $authorName
     * @param string[] $tags
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
        private array              $tags,
        private \DateTimeImmutable $createdAt,
    )
    {
        $this->status = ReviewStatus::PENDING;
    }

    public static function create(
        ReviewId   $id,
        TenantId   $tenantId,
        ProductSku $productSku,
        Rating     $rating,
        string     $title,
        string     $body,
        string     $authorName,
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

    public function status(): ReviewStatus
    {
        return $this->status;
    }

    public function rejectionReason(): ?string
    {
        return $this->rejectionReason;
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

    private function changeStatus(ReviewStatus $newStatus): void
    {
        if (!$this->status->canTransitionTo($newStatus)) {
            throw InvalidStatusTransitionException::create($this->status, $newStatus);
        }
        $this->status = $newStatus;
    }

    public function approve(): void
    {
        $this->changeStatus(ReviewStatus::APPROVED);
    }

    public function reject(string $reason): void
    {
        $this->changeStatus(ReviewStatus::REJECTED);
        $this->rejectionReason = $reason;
    }
}
 