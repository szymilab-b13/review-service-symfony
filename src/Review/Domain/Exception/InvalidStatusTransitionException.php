<?php declare(strict_types=1);

namespace App\Review\Domain\Exception;

use App\Review\Domain\Enum\ReviewStatus;
/**
 * Class InvalidStatusTransitionException
 * @package App\Review\Domain\Exception
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
final class InvalidStatusTransitionException extends \DomainException
{
    public static function create(ReviewStatus $from, ReviewStatus $to): self
    {
        return new self(
            sprintf('Cannot transition review from "%s" to "%s".', $from->value, $to->value)
        );
    }
}
 