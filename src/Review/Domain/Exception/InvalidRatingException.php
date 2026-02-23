<?php declare(strict_types=1);

namespace App\Review\Domain\Exception;

/**
 * Class InvalidRatingException
 * @package App\Review\Domain\Exception
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
final class InvalidRatingException extends \InvalidArgumentException
{
    public static function outOfRange(int $value): self
    {
        return new self(
            sprintf('Rating must be between 1 and 50 (0.1 - 5.0), got %d.', $value)
        );
    }
}
 