<?php declare(strict_types=1);

namespace App\Review\Domain\ValueObject;

/**
 * Class ProductSku
 * @package App\Review\Domain\ValueObject
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
final readonly class ProductSku
{
    private function __construct(public string $value)
    {}

    public static function fromString(string $sku): self
    {
        if (empty($sku)) {
            throw new \InvalidArgumentException('Product SKU cannot be empty.');
        }
        return new self($sku);
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
 