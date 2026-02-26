<?php declare(strict_types=1);

namespace App\Review\Infrastructure\Console;

use Elastic\Elasticsearch\Client;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
/**
 * Class ReindexCommand
 * @package App\Review\Infrastructure\Console
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */

#[AsCommand(name: 'app:es:create-index', description: 'Creates the reviews Elasticsearch index')]
final class CreateReviewIndexCommand extends Command
{
    public function __construct(
        private Client $client,
        private string $indexPrefix,
    ) {
        parent::__construct();
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $indexName = $this->indexPrefix . '_reviews';

        if ($this->client->indices()->exists(['index' => $indexName])->asBool()) {
            $io->warning("Index '$indexName' already exists.");
            return Command::SUCCESS;
        }

        $this->client->indices()->create([
            'index' => $indexName,
            'body' => [
                'mappings' => [
                    'properties' => [
                        'tenant_id'   => ['type' => 'keyword'],
                        'product_sku' => ['type' => 'keyword'],
                        'rating'      => ['type' => 'integer'],
                        'title'       => ['type' => 'text', 'analyzer' => 'standard'],
                        'body'        => ['type' => 'text', 'analyzer' => 'standard'],
                        'author_name' => ['type' => 'text'],
                        'author_id'   => ['type' => 'keyword'],
                        'status'      => ['type' => 'keyword'],
                        'tags'        => ['type' => 'keyword'],
                        'created_at'  => ['type' => 'date'],
                    ],
                ],
            ],
        ]);

        $io->success("Index '$indexName' created.");
        return Command::SUCCESS;
    }
}
 