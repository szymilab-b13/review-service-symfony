<?php declare(strict_types=1);

namespace App\Review\Infrastructure\Console;

use App\Review\Application\Port\ReviewIndexerInterface;
use App\Review\Domain\Repository\ReviewRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class ReindexReviewsCommand
 * @package App\Review\Infrastructure\Console
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
#[AsCommand(name: 'app:es:reindex-reviews',  description: 'Reindex all reviews from DB to Elasticsearch',)]
class ReindexReviewsCommand extends Command
{
    public function __construct(
        private ReviewRepository $repository,
        private ReviewIndexerInterface $indexer,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $reviews = $this->repository->findAll();
        $count = count($reviews);

        $io->info(sprintf('Reindexing %d reviews...', $count));

        $indexed = 0;
        foreach ($reviews as $review) {
            $this->indexer->index($review);
            $indexed++;
        }

        $io->success(sprintf('Reindexed %d/%d reviews.', $indexed, $count));

        return Command::SUCCESS;
    }
}
 