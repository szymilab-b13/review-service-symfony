<?php declare(strict_types=1);

namespace App\Review\Application\EventHandler;

use App\Review\Application\Port\ReviewIndexerInterface;
use App\Review\Domain\Event\ReviewCreatedEvent;
use App\Review\Domain\Repository\ReviewRepository;
use App\Review\Domain\ValueObject\ReviewId;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
/**
 * Class IndexReviewOnCreated
 * @package App\Review\Application\EventHandler
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */

#[AsMessageHandler]
final readonly class IndexReviewOnCreated
{
    public function __construct(
        private ReviewRepository $repository,
        private ReviewIndexerInterface $indexer,
    ) {}

    public function __invoke(ReviewCreatedEvent $event): void
    {
        $review = $this->repository->getById(ReviewId::fromString($event->reviewId));
        $this->indexer->index($review);
    }
}
 