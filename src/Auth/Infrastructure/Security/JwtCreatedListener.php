<?php declare(strict_types=1);

namespace App\Auth\Infrastructure\Security;


use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

/**
 * Class JwtCreatedListener
 * @package App\Auth\Infrastructure\Security
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */

#[AsEventListener(event: 'lexik_jwt_authentication.on_jwt_created')]
final class JwtCreatedListener
{
    public function __invoke(JWTCreatedEvent $event): void
    {
        /** @var SecurityUser $user */
        $user = $event->getUser();
        $payload = $event->getData();

        $payload['user_id'] = (string) $user->getDomainUser()->id();

        $event->setData($payload);
    }
}
 