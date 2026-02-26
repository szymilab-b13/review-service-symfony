<?php declare(strict_types=1);

namespace App\Review\Infrastructure\Http\Controller;

use App\Review\Application\Port\ReviewSearchInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
/**
 * Class SearchReviewsController
 * @package App\Review\Infrastructure\Http\Controller
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */

#[AsController]
final readonly class SearchReviewsController
{
    public function __construct(
        private ReviewSearchInterface $search,
    ) {}

    #[Route('/api/reviews/search', name: 'review_search', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function __invoke(Request $request): JsonResponse
    {
        $query = $request->query->getString('q', '');
        $filters = [];

        if ($request->query->has('status')) {
            $filters['status'] = $request->query->getString('status');
        }

        if ($request->query->has('product_sku')) {
            $filters['product_sku'] = $request->query->getString('product_sku');
        }

        if ($request->query->has('tag')) {
            $filters['tags'] = $request->query->getString('tag');
        }

        $results = $this->search->search($query, $filters);

        return new JsonResponse(['results' => $results, 'total' => count($results)]);
    }
}
 