<?php

declare(strict_types=1);

namespace Module\Users\Infrastructure\Repository\MongoDB;

use Module\Users\Domain\Contracts\FindByEmailRepository;
use Module\Users\Domain\Contracts\UpsertRepository;
use Module\Users\Domain\UserAggregate;
use Module\Users\Infrastructure\Repository\MongoDB\Models\UserModel;
use Module\Users\Domain\Email;

class UserRepository implements UpsertRepository, FindByEmailRepository
{
	public function __construct(private UserModel $model)
	{
	}

	public function upsert(UserAggregate $user): void
	{
		$userModel = $this->model->newInstance($user->toArray());
		$userModel->save();
	}

	public function findByEmail(Email $email): ?UserAggregate
	{
		$user = $this->model->findByEmail($email->getValue());
		if ($user) {
			return new UserAggregate($user->id, $user->email, $user->password);
		}
	}
}