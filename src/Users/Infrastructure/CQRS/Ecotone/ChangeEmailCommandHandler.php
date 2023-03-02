<?php

declare(strict_types=1);

namespace Module\Users\Infrastructure\CQRS\Ecotone;

use Ecotone\Messaging\Attribute\Asynchronous;
use Ecotone\Modelling\Attribute\CommandHandler;
use Ecotone\Modelling\EventBus;
use Module\Users\Application\Commands\ChangeEmailCommand;
use Module\Users\Application\Commands\ChangeEmailHandler;
use Module\Users\Application\Events\EmailChangedEvent;

class ChangeEmailCommandHandler
{
    #[Asynchronous('users-commands')]
    #[CommandHandler(endpointId: 'ChangeEmailCommandHandler.handle')]
    public function handle(ChangeEmailCommand $command, ChangeEmailHandler $handler, EventBus $eventBus): void
    {
        $result = $handler->handle($command);
        $emailChangedEvent = new EmailChangedEvent($result);
        $eventBus->publish($emailChangedEvent);
    }
}
