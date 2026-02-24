<?php declare(strict_types=1);

namespace App\Review\Application\Command;

use App\Review\Domain\Repository\ReviewRepository;
use App\Review\Domain\ValueObject\ReviewId;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
/**
 * Class RejectReviewCommandHandler
 * @package App\Review\Application\Command
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
#[AsMessageHandler]
final readonly class RejectReviewCommandHandler
{
    public function __construct(
        private ReviewRepository $repository,
    ) {}

    public function __invoke(RejectReviewCommand $command): void
    {
        $review = $this->repository->getById(
            ReviewId::fromString($command->reviewId)
        );

        $review->reject($command->reason);
        $this->repository->save($review);
    }
}
 