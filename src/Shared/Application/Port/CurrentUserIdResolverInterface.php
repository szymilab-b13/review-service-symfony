<?php declare(strict_types=1);

namespace App\Shared\Application\Port;

/**
 * Interface CurrentUserIdResolverInterface
 * @package App\Shared\Port
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
interface CurrentUserIdResolverInterface
{
    public function resolve(): string;
}