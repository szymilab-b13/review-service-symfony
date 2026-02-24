<?php declare(strict_types=1);

namespace App\Review\Domain\Exception;

use App\Shared\Domain\Exception\NotFoundException;

/**
 * Class ReviewNotFoundException
 * @package App\Review\Domain\Exception
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
final class ReviewNotFoundException extends \RuntimeException implements NotFoundException
{
    public static function withId(string $id): self
    {
        return new self(
            sprintf('Review with id "%s" not found.', $id)
        );
    }
}
 