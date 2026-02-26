<?php declare(strict_types=1);

namespace App\Review\Application\Command;


use App\Review\Domain\Entity\Review;
use App\Review\Domain\Repository\ReviewRepository;
use App\Review\Domain\Service\ReviewCreationPolicy;
use App\Review\Domain\ValueObject\ProductSku;
use App\Review\Domain\ValueObject\Rating;
use App\Review\Domain\ValueObject\ReviewId;
use App\Review\Domain\ValueObject\TenantId;
use App\Shared\Domain\ValueObject\UserId;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Class CreateReviewCommandHandler
 * @package App\Review\Application\Command
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */

#[AsMessageHandler]
final readonly class CreateReviewCommandHandler
{
    public function __construct(
        private ReviewRepository $repository,
        private ReviewCreationPolicy $policy,
        private MessageBusInterface $eventBus,
    ) {}

    public function __invoke(CreateReviewCommand $command): void
    {
        $tenantId   = TenantId::fromString($command->tenantId);
        $productSku = ProductSku::fromString($command->productSku);

        /**
         * business validation via domain policy
         */
        $this->policy->ensureTenantExists($tenantId);
        $this->policy->ensureProductExists($tenantId, $productSku);

        $review = Review::create(
            id: ReviewId::fromString($command->reviewId),
            tenantId: $tenantId,
            productSku: $productSku,
            rating: Rating::fromInt($command->rating),
            title: $command->title,
            body: $command->body,
            authorName: $command->authorName,
            authorId: UserId::fromString($command->authorId),
            tags: $command->tags,
        );

        $this->repository->save($review);

        foreach ($review->pullEvents() as $event) {
            $this->eventBus->dispatch($event);
        }
    }
}
 