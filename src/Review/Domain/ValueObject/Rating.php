<?php declare(strict_types=1);

namespace App\Review\Domain\ValueObject;

use App\Review\Domain\Exception\InvalidRatingException;
/**
 * Class Rating
 * @package App\Review\Domain\ValueObject
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
final readonly class Rating
{
    private function __construct(public int $value)
    {}

    /**
     * @param int $value
     * @description rating 1-50 (represents 0.1 - 5.0)
     * @return self
     */
    public static function fromInt(int $value): self
    {
        if ($value < 1 || $value > 50) {
            throw InvalidRatingException::outOfRange($value);
        }
        return new self($value);
    }

    /**
     * @description display value (e.g. 45 → 4.5)
     * @return float
     */
    public function toFloat(): float
    {
        return $this->value / 10;
    }
}
 