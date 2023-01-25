<?php

declare(strict_types=1);

namespace Module\Users\Infrastructure\Providers\Illuminate;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application;
use Module\Users\Domain\Contracts\UpsertRepository;
use Module\Users\Domain\Contracts\FindByEmailRepository;
use Module\Users\Infrastructure\CQRS\Ecotone\RegisterCommandHandler;
use Module\Users\Infrastructure\Repository\MongoDB\UserRepository;
use Module\Users\Application\Commands\RegisterHandler;

class UsersProvider extends ServiceProvider
{
	public function register(): void
	{
		$this->app->bind(
			UpsertRepository::class,
			UserRepository::class
		);
		$this->app->bind(
			FindByEmailRepository::class,
			UserRepository::class
		);
	}
}