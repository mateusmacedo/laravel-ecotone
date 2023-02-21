<?php

declare(strict_types=1);

namespace Module\Users\Infrastructure\EDA\Ecotone;

use Ecotone\Messaging\Attribute\Asynchronous;
use Ecotone\Modelling\Attribute\EventHandler;
use Module\Users\Application\Events\UserRegisteredEvent;
use Module\Users\Application\Events\UserRegisteredHandler;

class UserRegisteredEventHandler
{
    #[Asynchronous('users')]
    #[EventHandler(endpointId: 'UserRegisteredEventHandler.sendEmail')]
    public function sendEmail(UserRegisteredEvent $event, UserRegisteredHandler $handler): void
    {
        $handler->handle($event);
    }
}
