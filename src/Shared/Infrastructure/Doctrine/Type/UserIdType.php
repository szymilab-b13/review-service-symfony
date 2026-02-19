<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\Doctrine\Type;


use App\Shared\Domain\ValueObject\UserId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

/**
 * Class UserIdType
 * @package App\Shared\Infrastructure\Doctrine\Type
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
class UserIdType extends StringType
{
    public const NAME = 'user_id';

    public function convertToPHPValue($value, AbstractPlatform $platform): ?UserId
    {
        if ($value === null) {
            return null;
        }

        return UserId::fromString($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value === null) {
            return null;
        }

        return $value instanceof UserId ? $value->value : (string) $value;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
 