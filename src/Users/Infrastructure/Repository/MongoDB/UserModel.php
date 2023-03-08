<?php

declare(strict_types=1);

namespace Module\Users\Infrastructure\Repository\MongoDB;

use Module\Core\Infrastructure\Database\MongoDB\BaseModel;

class UserModel extends BaseModel
{
    protected $connection = 'mongodb';
    protected $table = 'users';
    protected $fillable = [
        'id',
        'email',
        'password'
    ];
}
