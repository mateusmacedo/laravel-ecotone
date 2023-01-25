<?php

declare(strict_types=1);

namespace Module\Users\Application\Commands;

use Module\Core\Domain\Exception\ValidationExceptions;
use Module\Users\Domain\Contracts\UpsertRepository;
use Module\Users\Domain\UserAggregate;
use Module\Users\Application\Commands\RegisterCommand;

class RegisterHandler
{
	public function __construct(private UpsertRepository $repository)
	{
	}

	public function handle(RegisterCommand $command): void
	{
		$dto = $command->getDto();
		$user = UserAggregate::register($dto->getEmail(), $dto->getPassword());
		$user->validate();
		if ($user->hasAnyException()) {
			throw new ValidationExceptions($user->getExceptions());
		}
		$this->repository->upsert($user);
	}
}