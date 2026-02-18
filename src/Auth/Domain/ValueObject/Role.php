<?php declare(strict_types=1);

namespace App\Auth\Domain\ValueObject;

/**
 * Enum Role
 * @package App\Auth\Domain\ValueObject
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
enum Role: string
{
    case USER = 'ROLE_USER';
    case ADMIN = 'ROLE_ADMIN';
    case MODERATOR = 'ROLE_MODERATOR';
}
 