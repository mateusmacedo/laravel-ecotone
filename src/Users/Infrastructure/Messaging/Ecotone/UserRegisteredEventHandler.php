<?php

declare(strict_types=1);

namespace Module\Users\Infrastructure\Messaging\Ecotone;

use Ecotone\Messaging\Attribute\Asynchronous;
use Ecotone\Messaging\Attribute\MessageConsumer;
use Module\Users\Application\Events\UserRegisteredEvent;
use Module\Users\Application\Events\UserRegisteredHandler;

class UserRegisteredEventHandler
{
    #[Asynchronous('orders')]
    #[MessageConsumer("sendRegistrationEmail")]
    public function sendEmail(UserRegisteredEvent $event, UserRegisteredHandler $handler): void
    {
        $handler->handle($event);
    }
}
