<?php declare(strict_types=1);

namespace App\Shared\Domain\Aggregate;

/**
 * Trait RecordsEvents
 * @package App\Shared\Domain\Aggregate
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
trait RecordsEvents
{
    private array $domainEvents = [];

    protected function record(object $event): void
    {
        $this->domainEvents[] = $event;
    }

    /** @return object[] */
    public function pullEvents(): array
    {
        $events = $this->domainEvents;
        $this->domainEvents = [];
        return $events;
    }
}
 