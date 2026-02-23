<?php declare(strict_types=1);

namespace App\Review\Domain\Enum;

/**
 * Enum ReviewStatus
 * @package App\Review\Domain\Enum
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
enum ReviewStatus: string
{
    case PENDING  = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';

    public function canTransitionTo(self $new): bool
    {
        return match ($this) {
            self::PENDING  => in_array($new, [self::APPROVED, self::REJECTED], true),
            self::APPROVED,
            self::REJECTED => false,
        };
    }
}
 