<?php declare(strict_types=1);

namespace App\Auth\Domain\Exception;

use App\Auth\Domain\ValueObject\Email;

/**
 * Class UserAlreadyExistsException
 * @package App\Auth\Domain\Exception
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
final class UserAlreadyExistsException extends \DomainException
{
    public function __construct(Email $email)
    {
        parent::__construct(
            sprintf('User with email "%s" already exists.', $email->toString())
        );
    }
}
 