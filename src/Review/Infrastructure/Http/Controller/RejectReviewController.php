<?php declare(strict_types=1);

namespace App\Review\Infrastructure\Http\Controller;

use App\Review\Application\Command\RejectReviewCommand;
use App\Review\Infrastructure\Http\Request\RejectReviewRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Class RejectReviewController
 * @package App\Review\Infrastructure\Http\Controller
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */

#[AsController]
final readonly class RejectReviewController
{
    public function __construct(
        private MessageBusInterface $messageBus,
    ) {

    }

    #[Route('/api/reviews/{id}/reject', name: 'review_reject', methods: ['PATCH'])]
    public function __invoke(
        string $id,
        #[MapRequestPayload] RejectReviewRequest $request,
    ): JsonResponse
    {
        $this->messageBus->dispatch(
            new RejectReviewCommand(
                reviewId: $id,
                reason: $request->reason,
            )
        );

        return new JsonResponse(
            ['message' => 'Review rejected.'],
            Response::HTTP_OK,
        );
    }
}
 