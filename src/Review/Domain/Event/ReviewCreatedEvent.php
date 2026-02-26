<?php declare(strict_types=1);

namespace App\Review\Domain\Event;

/**
 * Class ReviewCreatedEvent
 * @package App\Review\Domain\Event
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
final readonly class ReviewCreatedEvent
{
    public function __construct(
        public string $reviewId,
    ) {}
}
 