<?php declare(strict_types=1);

namespace App\Auth\Infrastructure\Doctrine\Type;

use App\Auth\Domain\ValueObject\Role;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\JsonType;

/**
 * Class RolesType
 * @package App\Auth\Infrastructure\Doctrine\Type
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
class RolesType extends JsonType
{
    public const NAME = 'roles_vo';

    public function convertToPHPValue($value, AbstractPlatform $platform): array
    {
        $roles = parent::convertToPHPValue($value, $platform);

        if (!is_array($roles)) {
            return [];
        }

        return array_map(
            fn(string $role) => Role::from($role),
            $roles
        );
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (!is_array($value)) {
            return parent::convertToDatabaseValue([], $platform);
        }

        $strings = array_map(
            fn(Role|string $role) => $role instanceof Role ? $role->value : $role,
            $value
        );

        return parent::convertToDatabaseValue($strings, $platform);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
 