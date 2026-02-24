<?php declare(strict_types=1);

namespace App\Review\Infrastructure\Http\Controller;

use App\Review\Application\Command\CreateReviewCommand;
use App\Review\Infrastructure\Http\Request\CreateReviewRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Uuid;
/**
 * Class CreateReviewController
 * @package App\Review\Infrastructure\Http\Controller
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */

#[AsController]
final readonly class CreateReviewController
{
    public function __construct(
        private MessageBusInterface $messageBus,
    ) {
    }

    #[Route('/api/reviews', name: 'review_create', methods: ['POST'])]
    public function __invoke(
        #[MapRequestPayload] CreateReviewRequest $request,
    ): JsonResponse
    {
        $reviewId = Uuid::v4()->toRfc4122();

        $this->messageBus->dispatch(
            new CreateReviewCommand(
                reviewId: $reviewId,
                tenantId: $request->tenantId,
                productSku: $request->productSku,
                rating: $request->rating,
                title: $request->title,
                body: $request->body,
                authorName: $request->authorName,
                tags: $request->tags,
            )
        );

        return new JsonResponse(
            ['id' => $reviewId, 'message' => 'Review created.'],
            Response::HTTP_CREATED,
        );
    }
}
 