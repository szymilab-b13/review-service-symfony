<?php declare(strict_types=1);

namespace App\Review\Infrastructure\Doctrine\Type;

use App\Review\Domain\ValueObject\ProductSku;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

/**
 * Class ProductSkuType
 * @package App\Review\Infrastructure\Doctrine\Type
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
final class ProductSkuType extends StringType
{
    public const NAME = 'product_sku_vo';

    public function convertToPHPValue($value, AbstractPlatform $platform): ?ProductSku
    {
        if ($value === null) {
            return null;
        }

        return ProductSku::fromString($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value === null) {
            return null;
        }

        return $value instanceof ProductSku ? $value->value : (string) $value;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
 