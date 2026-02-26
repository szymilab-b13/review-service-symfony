<?php declare(strict_types=1);

namespace App\Review\Infrastructure\Http\Controller;



use App\Review\Application\Command\AddCommentCommand;
use App\Review\Infrastructure\Http\Request\AddCommentRequest;
use App\Shared\Application\Port\CurrentUserIdResolverInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Uid\Uuid;
/**
 * Class AddCommentController
 * @package App\Review\Infrastructure\Http\Controller
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */

#[AsController]
final readonly class AddCommentController
{
    public function __construct(
        private MessageBusInterface $messageBus,
        private CurrentUserIdResolverInterface $currentUserId,
    ) {}

    #[Route('/api/reviews/{reviewId}/comments', name: 'review_add_comment', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function __invoke(
        string $reviewId,
        #[MapRequestPayload] AddCommentRequest $request,
    ): JsonResponse
    {
        $commentId = Uuid::v4()->toRfc4122();

        $this->messageBus->dispatch(
            new AddCommentCommand(
                commentId: $commentId,
                reviewId: $reviewId,
                authorId: $this->currentUserId->resolve(),
                authorName: $request->authorName,
                content: $request->content,
            )
        );

        return new JsonResponse(
            ['id' => $commentId, 'message' => 'Comment added.'],
            Response::HTTP_CREATED,
        );
    }
}
 