<?php

declare(strict_types=1);

namespace Module\Users\Infrastructure\Repository\MongoDB\Models;

class UserModel extends BaseModel
{
    protected $connection = 'mongodb';
    protected $table = 'users';
    protected $fillable = [
        'uuid',
        'email',
        'password'
    ];

    public function findByEmail(string $email): mixed
    {
        return self::where('email', $email)->first();
    }

    public function findById(string $id): mixed
    {
        return self::where('id', $id)->first();
    }
}
