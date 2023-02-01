<?php

declare(strict_types=1);

namespace Module\Users\Infrastructure\Repository\MongoDB;

use Module\Users\Domain\Email;
use Module\Users\Domain\Repositories\FindByEmailRepository;
use Module\Users\Domain\Repositories\FindByIdRepository;
use Module\Users\Domain\Repositories\UpsertRepository;
use Module\Users\Domain\UserAggregate;
use Module\Users\Infrastructure\Repository\MongoDB\Models\UserModel;

class UserRepository implements UpsertRepository, FindByEmailRepository, FindByIdRepository
{
    public function __construct(private UserModel $model)
    {
    }

    public function upsert(UserAggregate $user): void
    {
        $userModel = $this->model->findById($user->getId());
        if (!$userModel) {
            $userModel = $this->model->newInstance($user->toArray());
        }
        $userModel->fill($user->toArray());
        $userModel->save();
    }

    public function findByEmail(Email $email): ?UserAggregate
    {
        $user = $this->model->findByEmail($email->getValue());
        if ($user) {
            return UserAggregate::fromArray($user->toArray());
        }
        return null;
    }

    public function findById(string $id): ?UserAggregate
    {
        $user = $this->model->findById($id);
        if ($user) {
            return UserAggregate::fromArray($user->toArray());
        }
        return null;
    }
}
