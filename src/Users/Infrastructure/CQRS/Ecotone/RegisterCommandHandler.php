<?php

declare(strict_types=1);

namespace Module\Users\Infrastructure\CQRS\Ecotone;

use Ecotone\Messaging\MessagePublisher;
use Ecotone\Modelling\Attribute\CommandHandler;
use Ecotone\Modelling\EventBus;
use Module\Users\Application\Commands\RegisterCommand;
use Module\Users\Application\Commands\RegisterHandler;

class RegisterCommandHandler
{
	#[CommandHandler]
	public function handle(RegisterCommand $command, RegisterHandler $handler, MessagePublisher $messagePublisher): void
	{
		$handler->handle($command, $messagePublisher);
	}
}