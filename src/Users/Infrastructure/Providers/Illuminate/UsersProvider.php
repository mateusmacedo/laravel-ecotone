<?php

declare(strict_types=1);

namespace Module\Users\Infrastructure\Providers\Illuminate;

use Illuminate\Support\ServiceProvider;
use Module\Users\Domain\Repository\IUserRepository;
use Module\Users\Infrastructure\Repository\MongoDB\UserRepository;
use Module\Users\Mapper\UsersMapper;

class UsersProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(IUserRepository::class, UserRepository::class);
        $this->app->singleton(UsersMapper::class, UsersMapper::class);
    }
}
