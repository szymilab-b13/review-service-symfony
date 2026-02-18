<?php declare(strict_types=1);

namespace App\Auth\Domain\ValueObject;

/**
 * Class Email
 * @package App\Auth\Domain\ValueObject
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
final readonly class Email
{
    private function __construct(public string $value)
    {

    }

    public static function fromString(string $email): self
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException(
                sprintf('Invalid email: "%s"', $email)
            );
        }

        return new self(mb_strtolower($email));
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
 