<?php declare(strict_types=1);

namespace App\Review\Infrastructure\Doctrine\Type;

use App\Review\Domain\ValueObject\CommentId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

/**
 * Class CommentIdType
 * @package App\Review\Infrastructure\Doctrine\Type
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
final class CommentIdType extends StringType
{
    public const NAME = 'comment_id_vo';

    public function convertToPHPValue($value, AbstractPlatform $platform): ?CommentId
    {
        if ($value === null) {
            return null;
        }

        return CommentId::fromString($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value === null) {
            return null;
        }

        return $value instanceof CommentId ? $value->value : (string) $value;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
 