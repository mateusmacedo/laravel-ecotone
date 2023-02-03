<?php

declare(strict_types=1);

namespace Module\Users\Application\Factories;

use Module\Users\Application\Commands\ChangeEmailCommand;
use Module\Users\Application\Commands\ChangePasswordCommand;
use Module\Users\Application\Commands\RegisterCommand;
use Module\Users\Application\Dtos\ChangeEmailDto;
use Module\Users\Application\Dtos\ChangePasswordDto;
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

  public static function changeEmailCommand(ChangeEmailDto $dto): ChangeEmailCommand
  {
      return new ChangeEmailCommand($dto);
  }

    public static function changePasswordCommand(ChangePasswordDto $dto): ChangePasswordCommand
    {
        return new ChangePasswordCommand($dto);
    }
}
