<?php declare(strict_types=1);

namespace App\Review\Infrastructure\Search;

use App\Review\Application\Port\ReviewIndexerInterface;
use App\Review\Domain\Entity\Review;
use Elastic\Elasticsearch\Client;

/**
 * Class ElasticsearchReviewIndexer
 * @package App\Review\Infrastructure\Search
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
final class ElasticsearchReviewIndexer implements ReviewIndexerInterface
{
    private const INDEX = 'reviews';

    public function __construct(
        private Client $client,
        private string $indexPrefix,
    ) {}

    public function index(Review $review): void
    {
        $this->client->index([
            'index' => $this->indexPrefix . '_'.self::INDEX,
            'id'    => $review->id()->value,
            'body'  => [
                'tenant_id'   => $review->tenantId()->value,
                'product_sku' => $review->productSku()->value,
                'rating'      => $review->rating()->value,
                'title'       => $review->title(),
                'body'        => $review->body(),
                'author_name' => $review->authorName(),
                'author_id'   => $review->authorId()->value,
                'status'      => $review->status()->value,
                'tags'        => $review->tags(),
                'created_at'  => $review->createdAt()->format('c'),
            ],
        ]);
    }

    public function delete(string $reviewId): void
    {
        $this->client->delete([
            'index' => $this->indexPrefix . '_'.self::INDEX,
            'id'    => $reviewId,
        ]);
    }
}
 