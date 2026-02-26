<?php declare(strict_types=1);

namespace App\Review\Application\Command;

use App\Review\Domain\Repository\ReviewRepository;
use App\Review\Domain\ValueObject\CommentId;
use App\Review\Domain\ValueObject\ReviewId;
use App\Shared\Domain\ValueObject\UserId;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
/**
 * Class AddCommentCommandHandler
 * @package App\Review\Application\Command
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
#[AsMessageHandler]
final readonly class AddCommentCommandHandler
{
    public function __construct(
        private ReviewRepository $repository,
    ) {}

    public function __invoke(AddCommentCommand $command): void
    {
        $review = $this->repository->getById(
            ReviewId::fromString($command->reviewId)
        );

        $review->addComment(
            CommentId::fromString($command->commentId),
            UserId::fromString($command->authorId),
            $command->authorName,
            $command->content,
        );

        $this->repository->save($review);
    }
}
 