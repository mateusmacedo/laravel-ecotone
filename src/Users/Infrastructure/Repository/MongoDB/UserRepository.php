<?php

declare(strict_types=1);

namespace Module\Users\Infrastructure\Repository\MongoDB;

use Module\Core\Infrastructure\Database\MongoBaseRepository;
use Module\Users\Domain\Contracts\IUserRepository;
use Module\Users\Infrastructure\Repository\MongoDB\Models\UserModel;
use Module\Users\Mapper\UsersMapper;

class UserRepository extends MongoBaseRepository implements IUserRepository
{
    public function __construct(private UserModel $model, private UsersMapper $mapper)
    {
        parent::__construct($model, $mapper);
    }
}
