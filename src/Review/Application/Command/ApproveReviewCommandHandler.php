<?php declare(strict_types=1);

namespace App\Review\Application\Command;

use App\Review\Domain\Repository\ReviewRepository;
use App\Review\Domain\ValueObject\ReviewId;
use App\Shared\Domain\ValueObject\UserId;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * Class ApproveReviewCommandHandler
 * @package App\Review\Application\Command
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
#[AsMessageHandler]
final readonly class ApproveReviewCommandHandler
{
    public function __construct(
        private ReviewRepository $repository,
    ) {}

    public function __invoke(ApproveReviewCommand $command): void
    {
        $review = $this->repository->getById(
            ReviewId::fromString($command->reviewId)
        );

        $review->approve(UserId::fromString($command->moderatorId));
        $this->repository->save($review);
    }
}
 