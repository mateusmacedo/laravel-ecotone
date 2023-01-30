<?php

declare(strict_types=1);

namespace Module\Users\Infrastructure\Providers\Illuminate;

use Illuminate\Support\ServiceProvider;
use Module\Users\Domain\Repositories\FindByEmailRepository;
use Module\Users\Domain\Repositories\FindByIdRepository;
use Module\Users\Domain\Repositories\UpsertRepository;
use Module\Users\Infrastructure\Repository\MongoDB\UserRepository;

class UsersProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            UpsertRepository::class,
            UserRepository::class
        );
        $this->app->bind(
            FindByIdRepository::class,
            UserRepository::class
        );
        $this->app->bind(
            FindByEmailRepository::class,
            UserRepository::class
        );
    }
}
