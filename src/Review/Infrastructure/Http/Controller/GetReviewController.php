<?php declare(strict_types=1);

namespace App\Review\Infrastructure\Http\Controller;

use App\Review\Application\Query\GetReviewQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

/**
 * Class GetReviewController
 * @package App\Review\Infrastructure\Http\Controller
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
#[AsController]
final readonly class GetReviewController
{
    public function __construct(
        private MessageBusInterface $messageBus,
    ) {}

    #[Route(
        '/api/reviews/{id}',
        name: 'review_get',
        methods: ['GET'],
        requirements: ['id' => Requirement::UUID_V4]
    )]
    public function __invoke(string $id): JsonResponse
    {
        $envelope   = $this->messageBus->dispatch(new GetReviewQuery(reviewId: $id));
        $readModel  = $envelope->last(HandledStamp::class)?->getResult();

        return new JsonResponse((array) $readModel);
    }
}
 