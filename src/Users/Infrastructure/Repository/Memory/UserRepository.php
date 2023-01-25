<?php

declare(strict_types=1);

namespace Module\Users\Infrastructure\Repository\Memory;

use Module\Users\Domain\Contracts\FindByEmailRepository;
use Module\Users\Domain\Contracts\UpsertRepository;
use Module\Users\Domain\UserAggregate;
use Module\Users\Domain\Email;

class UserRepository implements UpsertRepository, FindByEmailRepository
{
	private $users = [];

	public function upsert(UserAggregate $user): void
	{
		$this->users[$user->getId()] = $user;
	}

	public function findByEmail(Email $email): ?UserAggregate
	{
		foreach ($this->users as $user) {
			if ($user->getEmail()->equals($email)) {
				return $user;
			}
		}
		return null;
	}
}