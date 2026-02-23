<?php declare(strict_types=1);

namespace App\Review\Application\Command;

/**
 * Class ApproveReviewCommand
 * @package App\Review\Application\Command
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
final readonly class ApproveReviewCommand
{
    public function __construct(
        public string $reviewId,
    ) {}
}
 