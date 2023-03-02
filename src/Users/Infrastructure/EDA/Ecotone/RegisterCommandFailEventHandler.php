<?php

declare(strict_types=1);

namespace Module\Users\Infrastructure\EDA\Ecotone;

use Ecotone\Messaging\Attribute\Asynchronous;
use Ecotone\Modelling\Attribute\EventHandler;
use Module\Users\Application\Events\RegisterCommandFailEvent;
use Module\Users\Application\Events\RegisterCommandFailHandler;

class RegisterCommandFailEventHandler
{
    #[Asynchronous('users-events')]
    #[EventHandler(endpointId: 'RegisterCommandFailEventHandler.handle')]
    public function handle(RegisterCommandFailEvent $event, RegisterCommandFailHandler $handler): void
    {
        $handler->handle($event);
    }
}
