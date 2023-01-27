<?php

declare(strict_types=1);

namespace Module\Users\Application\Events;

use Ecotone\Messaging\Attribute\Asynchronous;
use Ecotone\Modelling\Attribute\EventHandler;
use Illuminate\Support\Facades\Log;


class UserRegisteredHandler
{
	public function handle(UserRegisteredEvent $event): void
	{
		Log::info("Sending email to user {$event->getUserId()}");
	}
}