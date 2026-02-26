<?php declare(strict_types=1);

namespace App\Shared\Application\Port;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Interface IdentifiableUserInterface
 * @package App\Shared\Application\Port
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
interface IdentifiableUserInterface extends UserInterface
{
    public function userId(): string;
}