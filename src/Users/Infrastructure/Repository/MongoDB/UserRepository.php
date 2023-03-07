<?php

declare(strict_types=1);

namespace Module\Users\Infrastructure\Repository\MongoDB;

use Module\Core\Infrastructure\Database\MongoDB\MongoBaseRepository;
use Module\Users\Domain\Repository\IUserRepository;
use Module\Users\Domain\UserAggregate;
use Module\Users\Mapper\UsersMapper;

class UserRepository extends MongoBaseRepository implements IUserRepository
{
    public function __construct(private UserModel $model, private UsersMapper $mapper)
    {
        parent::__construct($model, $mapper);
    }

    public function findOne(array $filter): ?UserAggregate
    {
        return parent::findOne($filter);
    }
}
