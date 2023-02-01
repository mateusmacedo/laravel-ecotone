<?php

declare(strict_types=1);

namespace Module\Users\Infrastructure\CQRS\Ecotone;

use Ecotone\Modelling\Attribute\CommandHandler;
use Module\Users\Application\Commands\ChangeEmailCommand;
use Module\Users\Application\Commands\ChangeEmailHandler;

class ChangeEmailCommandHandler
{
    #[CommandHandler]
    public function handle(ChangeEmailCommand $command, ChangeEmailHandler $handler): void
    {
        $handler->handle($command);
    }
}
