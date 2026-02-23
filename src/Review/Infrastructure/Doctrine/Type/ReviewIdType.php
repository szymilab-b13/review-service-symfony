<?php declare(strict_types=1);

namespace App\Review\Infrastructure\Doctrine\Type;

use App\Review\Domain\ValueObject\ReviewId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

/**
 * Class ReviewIdType
 * @package App\Review\Infrastructure\Doctrine\Type
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
final class ReviewIdType extends StringType
{
    public const NAME = 'review_id_vo';

    public function convertToPHPValue($value, AbstractPlatform $platform): ?ReviewId
    {
        if ($value === null) {
            return null;
        }

        return ReviewId::fromString($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value === null) {
            return null;
        }

        return $value instanceof ReviewId ? $value->value : (string) $value;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
 