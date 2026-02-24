<?php declare(strict_types=1);

namespace App\Review\Application\Query;

use App\Review\Application\ReadModel\ReviewReadModel;
use App\Review\Domain\Repository\ReviewRepository;
use App\Review\Domain\ValueObject\ReviewId;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
/**
 * Class GetReviewQueryHandler
 * @package App\Review\Application\Query
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
#[AsMessageHandler]
final readonly class GetReviewQueryHandler
{
    public function __construct(
        private ReviewRepository $repository,
    ) {}

    public function __invoke(GetReviewQuery $query): ReviewReadModel
    {
        $review = $this->repository->getById(ReviewId::fromString($query->reviewId));

        return new ReviewReadModel(
            id: $review->id()->value,
            tenantId: $review->tenantId()->value,
            productSku: $review->productSku()->value,
            rating: $review->rating()->value,
            title: $review->title(),
            body: $review->body(),
            authorName: $review->authorName(),
            status: $review->status()->value,
            rejectionReason: $review->rejectionReason(),
            tags: $review->tags(),
            createdAt: $review->createdAt()->format('c'),
        );
    }
}
 