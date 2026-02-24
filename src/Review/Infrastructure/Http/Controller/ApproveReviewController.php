<?php declare(strict_types=1);

namespace App\Review\Infrastructure\Http\Controller;

use App\Review\Application\Command\ApproveReviewCommand;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

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
    ) {

    }

    #[Route('/api/reviews/{id}/approve', name: 'review_approve', methods: ['PATCH'])]
    public function __invoke(string $id): JsonResponse
    {
        $this->messageBus->dispatch(
            new ApproveReviewCommand(reviewId: $id)
        );

        return new JsonResponse(
            ['message' => 'Review approved.'],
            Response::HTTP_OK,
        );
    }
}
 