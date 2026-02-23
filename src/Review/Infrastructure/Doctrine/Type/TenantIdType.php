<?php declare(strict_types=1);

namespace App\Review\Infrastructure\Doctrine\Type;

use App\Review\Domain\ValueObject\TenantId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

/**
 * Class TenantIdType
 * @package App\Review\Infrastructure\Doctrine\Type
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
final class TenantIdType extends StringType
{
    public const NAME = 'tenant_id_vo';

    public function convertToPHPValue($value, AbstractPlatform $platform): ?TenantId
    {
        if ($value === null) {
            return null;
        }

        return TenantId::fromString($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value === null) {
            return null;
        }

        return $value instanceof TenantId ? $value->value : (string) $value;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
 