<?php

/* declare(strict_types=1);

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
            $userModel = $this->model->newInstance($user->arraySerialize());
        }
        $userModel->fill($user->arraySerialize());
        $userModel->save();
    }

    public function findByEmail(Email $email): ?UserAggregate
    {
        $user = $this->model->findByEmail($email->getValue())->first();
        if ($user) {
            return UserAggregate::fromArray($user->toArray());
        }
        return null;
    }

    public function findById(string $id): ?UserAggregate
    {
        $user = $this->model->findById($id)->first();
        if ($user) {
            return UserAggregate::fromArray($user->toArray());
        }
        return null;
    }
}
 */

declare(strict_types=1);

namespace Module\Users\Infrastructure\Repository\MongoDB;

use Module\Core\Infrastructure\Database\MongoBaseRepository;
use Module\Users\Domain\Contracts\FindByEmailRepository;
use Module\Users\Domain\Contracts\IUserRepository;
use Module\Users\Domain\Contracts\UpsertRepository;
use Module\Users\Domain\UserAggregate;
use Module\Users\Infrastructure\Repository\MongoDB\Models\UserModel;
use Module\Users\Domain\Email;
use Module\Users\Mapper\UsersMapper;

class UserRepository extends MongoBaseRepository implements IUserRepository
{
    public function __construct(private UserModel $model, private UsersMapper $mapper)
    {
        parent::__construct($model, $mapper);
    }
}
