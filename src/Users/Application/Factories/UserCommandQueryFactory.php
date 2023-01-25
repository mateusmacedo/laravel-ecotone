<?php

declare(strict_types=1);

namespace Module\Users\Application\Factories;

use Module\Users\Application\Commands\RegisterCommand;
use Module\Users\Application\Dtos\FindByEmailDto;
use Module\Users\Application\Dtos\RegisterDto;
use Module\Users\Application\Queries\FindByEmailQuery;

class UserCommandQueryFactory
{
	public static function registerCommand(RegisterDto $dto): RegisterCommand
	{
		return new RegisterCommand($dto);
	}

	public static function findByEmailQuery(FindByEmailDto $dto): FindByEmailQuery
	{
		return new FindByEmailQuery($dto);
	}
}