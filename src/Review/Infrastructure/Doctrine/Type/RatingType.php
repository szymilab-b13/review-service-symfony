<?php declare(strict_types=1);

namespace App\Review\Infrastructure\Doctrine\Type;

use App\Review\Domain\ValueObject\Rating;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

/**
 * Class RatingType
 * @package App\Review\Infrastructure\Doctrine\Type
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
final class RatingType extends Type
{
    public const NAME = 'rating_vo';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getIntegerTypeDeclarationSQL($column);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Rating
    {
        if ($value === null) {
            return null;
        }

        return Rating::fromInt((int) $value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?int
    {
        if ($value === null) {
            return null;
        }

        return $value instanceof Rating ? $value->value : (int) $value;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
 