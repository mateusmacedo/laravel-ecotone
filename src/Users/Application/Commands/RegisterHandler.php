<?php

declare(strict_types=1);

namespace Module\Users\Application\Commands;

use Ecotone\Messaging\MessagePublisher;
use Ecotone\Modelling\EventBus;
use Module\Core\Domain\Exception\ValidationExceptions;
use Module\Users\Application\Events\UserRegisteredEvent;
use Module\Users\Domain\Contracts\UpsertRepository;
use Module\Users\Domain\UserAggregate;
use Module\Users\Application\Commands\RegisterCommand;
use Illuminate\Support\Facades\Log;

class RegisterHandler
{
	public function __construct(private UpsertRepository $repository)
	{
	}

	public function handle(RegisterCommand $command, MessagePublisher $messagePublisher): void
	{
		$dto = $command->getDto();
		$user = UserAggregate::register($dto->getEmail(), $dto->getPassword());
		$user->validate();
		if ($user->hasAnyException()) {
			throw new ValidationExceptions($user->getExceptions());
		}
		$this->repository->upsert($user);
		$messagePublisher->send(json_encode(['userId' => $user->getId()]), 'application/json');
	}
}