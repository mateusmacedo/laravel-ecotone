<?php

declare(strict_types=1);

namespace Module\Users\Infrastructure\CQRS\Ecotone;

use Ecotone\Messaging\Attribute\Asynchronous;
use Ecotone\Modelling\Attribute\CommandHandler;
use Ecotone\Modelling\EventBus;
use Module\Users\Application\Commands\RegisterCommand;
use Module\Users\Application\Commands\RegisterHandler;
use Module\Users\Application\Events\RegisterCommandFailEvent;
use Module\Users\Application\Events\UserRegisteredEvent;

class RegisterCommandHandler
{
    #[Asynchronous('users-commands')]
    #[CommandHandler(endpointId: 'RegisterCommandHandler.handle')]
    public function handle(RegisterCommand $command, RegisterHandler $handler, EventBus $eventBus): void
    {
        $result = $handler->handle($command);
        if ($result->isError) {
            $eventBus->publish(new RegisterCommandFailEvent($command, $result->getError()));
        }
        $eventBus->publish(new UserRegisteredEvent($result->getValue()));
    }
}
