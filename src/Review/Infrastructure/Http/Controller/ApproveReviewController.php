<?php declare(strict_types=1);

namespace App\Review\Infrastructure\Http\Controller;

use App\Review\Application\Command\ApproveReviewCommand;
use App\Shared\Application\Port\CurrentUserIdResolverInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * Class ApproveReviewController
 * @package App\Review\Infrastructure\Http\Controller
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
#[AsController]
final readonly class ApproveReviewController
{
    public function __construct(
        private MessageBusInterface $messageBus,
        private CurrentUserIdResolverInterface $currentUserId,
    ) {

    }

    #[Route('/api/reviews/{id}/approve', name: 'review_approve', methods: ['PATCH'])]
    #[IsGranted('ROLE_MODERATOR')]
    public function __invoke(string $id): JsonResponse
    {

        $this->messageBus->dispatch(
            new ApproveReviewCommand(
                reviewId: $id,
                moderatorId: $this->currentUserId->resolve(),
            )
        );

        return new JsonResponse(
            ['message' => 'Review approved.'],
            Response::HTTP_OK,
        );
    }
}
 