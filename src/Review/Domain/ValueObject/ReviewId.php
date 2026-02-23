<?php declare(strict_types=1);

namespace App\Review\Domain\ValueObject;

use \Symfony\Component\Uid\Uuid;

/**
 * Class ReviewId
 * @package App\Review\Domain\ValueObject
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
final readonly class ReviewId
{
    private function __construct(public string $value)
    {

    }

    public static function generate(): self
    {
        return new self(Uuid::v4()->toRfc4122());
    }

    public static function fromString(string $id): self
    {
        if (!Uuid::isValid($id)) {
            throw new \InvalidArgumentException(
                sprintf('Invalid UUID format: "%s".', $id)
            );
        }

        return new self($id);
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
 