<?php declare(strict_types=1);

namespace App\Review\Application\Port;

/**
 * Interface ReviewSearchInterface
 * @package App\Review\Application\Port
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
interface ReviewSearchInterface
{
    /** @return array Search results */
    public function search(string $query, array $filters = []): array;
}