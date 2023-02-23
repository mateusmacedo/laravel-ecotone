<?php

declare(strict_types=1);

namespace Module\Users\Infrastructure\CQRS\Ecotone;

use Ecotone\Messaging\Attribute\Asynchronous;
use Ecotone\Modelling\Attribute\CommandHandler;
use Module\Users\Application\Commands\ChangePasswordCommand;
use Module\Users\Application\Commands\ChangePasswordHandler;

class ChangePasswordCommandHandler
{
    #[Asynchronous('users-redis')]
    #[CommandHandler(endpointId: 'ChangePasswordCommandHandler.handle')]
    public function handle(ChangePasswordCommand $command, ChangePasswordHandler $handler): void
    {
        $handler->handle($command);
    }
}
