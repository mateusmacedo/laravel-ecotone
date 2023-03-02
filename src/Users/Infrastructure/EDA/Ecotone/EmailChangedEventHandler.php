<?php

declare(strict_types=1);

namespace Module\Users\Infrastructure\EDA\Ecotone;

use Ecotone\Messaging\Attribute\Asynchronous;
use Ecotone\Modelling\Attribute\EventHandler;
use Module\Users\Application\Events\EmailChangedEvent;
use Module\Users\Application\Events\EmailChangedHandler;

class EmailChangedEventHandler
{
    #[Asynchronous('users-events')]
    #[EventHandler(endpointId: 'EmailChangedEventHandler.sendEmailHasChangedNotification')]
    public function sendEmailHasChangedNotification(EmailChangedEvent $event, EmailChangedHandler $handler): void
    {
        $handler->handle($event);
    }
}
