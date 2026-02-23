<?php declare(strict_types=1);

namespace App\Auth\Infrastructure\Doctrine\Type;

use App\Auth\Domain\ValueObject\HashedPassword;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

/**
 * Class HashedPasswordType
 * @package App\Auth\Infrastructure\Doctrine\Type
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
class HashedPasswordType extends StringType
{
    public const NAME = 'hashed_password_vo';

    public function convertToPHPValue($value, AbstractPlatform $platform): ?HashedPassword
    {
        if ($value === null) {
            return null;
        }

        return HashedPassword::fromString($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value === null) {
            return null;
        }

        return $value instanceof HashedPassword ? $value->toString() : (string) $value;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
 