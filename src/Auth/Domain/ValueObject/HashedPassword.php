<?php declare(strict_types=1);

namespace App\Auth\Domain\ValueObject;

/**
 * Class HashedPassword
 * @package App\Auth\Domain\ValueObject
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
final readonly class HashedPassword
{
    private function __construct(private string $value)
    {

    }

    public static function fromString(string $hash): self
    {
        if ($hash === '') {
            throw new \InvalidArgumentException('Hashed password cannot be empty.');
        }

        return new self($hash);
    }

    public function toString(): string
    {
        return $this->value;
    }
}
 