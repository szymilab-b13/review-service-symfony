<?php declare(strict_types=1);

namespace App\Review\Infrastructure\Search;
use App\Review\Application\Port\ReviewSearchInterface;
/**
 * Class SearchEngineReviewSearch
 * @package App\Review\Infrastructure\Search
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
final class SearchEngineReviewSearch implements ReviewSearchInterface
{
    public function __construct(
        private string $searchBackend,
    ) {
        // TODO: inject ElasticsearchClient and ReviewRepository for DB fallback
    }

    public function search(string $query, array $filters = []): array
    {
        //TODO: move as chain pattern ?
        if ($this->searchBackend === 'elastic') {
            return $this->searchElastic($query, $filters);
        }

        return $this->searchDatabase($query, $filters);
    }

    private function searchElastic(string $query, array $filters): array
    {
        // TODO:

        return [];
    }

    private function searchDatabase(string $query, array $filters): array
    {
        // TODO:

        return [];
    }
}
 