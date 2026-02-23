<?php declare(strict_types=1);

namespace App\Review\Infrastructure\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use App\Review\Domain\Enum\ReviewStatus;

/**
 * Class ReviewStatusType
 * @package App\Review\Infrastructure\Doctrine\Type
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
final class ReviewStatusType extends StringType
{
    public const NAME = 'review_status_vo';

    public function convertToPHPValue($value, AbstractPlatform $platform): ?ReviewStatus
    {
        return $value === null ? null : ReviewStatus::from($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value instanceof ReviewStatus ? $value->value : (string) $value;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
 