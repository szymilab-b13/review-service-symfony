<?php declare(strict_types=1);

namespace App\Review\Infrastructure\Search;
use App\Review\Application\Port\ReviewSearchInterface;
use Elastic\Elasticsearch\Client;

/**
 * Class SearchEngineReviewSearch
 * @package App\Review\Infrastructure\Search
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
final class SearchEngineReviewSearch implements ReviewSearchInterface
{
    private const INDEX = 'reviews';

    public function __construct(
        private Client $client,
        private string $indexPrefix,
    ) {}

    public function search(string $query, array $filters = []): array
    {
        return $this->searchElastic($query, $filters);

        //TODO: move as chain pattern ?
//        if ($this->searchBackend === 'elastic') {
//            return $this->searchElastic($query, $filters);
//        }

//        return $this->searchDatabase($query, $filters);
    }

    private function searchElastic(string $query, array $filters): array
    {
        $must = [];

        if ($query !== '') {
            $must[] = [
                'multi_match' => [
                    'query'  => $query,
                    'fields' => ['title^3', 'body', 'author_name', 'tags'],
                    'fuzziness' => 'AUTO',
                ],
            ];
        }

        foreach ($filters as $field => $value) {
            $must[] = ['term' => [$field => $value]];
        }

        $response = $this->client->search([
            'index' => $this->indexPrefix . '_'.self::INDEX,
            'body'  => [
                'query' => [
                    'bool' => [
                        'must' => $must ?: [['match_all' => (object)[]]],
                    ],
                ],
                'size' => 20,
            ],
        ]);

        return array_map(
            fn(array $hit) => $hit['_source'] + ['id' => $hit['_id']],
            $response['hits']['hits']
        );
    }

    private function searchDatabase(string $query, array $filters): array
    {
        // TODO:

        return [];
    }
}
 