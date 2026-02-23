<?php declare(strict_types=1);

namespace App\Review\Domain\ValueObject;

/**
 * Class TenantId
 * @package App\Review\Domain\ValueObject
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
final readonly class TenantId
{
    private function __construct(public string $value)
    {}

    public static function fromString(string $id): self
    {
        if (empty($id)) {
            throw new \InvalidArgumentException('TenantId cannot be empty.');
        }
        return new self($id);
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
 