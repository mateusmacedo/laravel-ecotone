<?php

declare(strict_types=1);

namespace Module\Users\Application\Factories;

use Module\Users\Application\Dtos\ChangeEmailDto;
use Module\Users\Application\Dtos\ChangePasswordDto;
use Module\Users\Application\Dtos\FindByEmailDto;
use Module\Users\Application\Dtos\RegisterDto;
use Module\Users\Domain\Email;
use Module\Users\Domain\Password;

class UserDtoFactory
{
    public function registerDto(array $data): RegisterDto
    {
        $email = new Email($data['email']);
        $password = new Password($data['password']);
        return new RegisterDto($email, $password);
    }

    public function findByEmailDto(array $data): FindByEmailDto
    {
        $email = new Email($data['email']);
        return new FindByEmailDto($email);
    }

  public function changeEmailDto(array $data): ChangeEmailDto
  {
      return new ChangeEmailDto(
          new Email($data['currentEmail']),
          new Email($data['newEmail']),
      );
  }
    public function changePasswordDto(array $data): ChangePasswordDto
    {
        $password = new Password($data['password']);
        $email = new Email($data['email']);
        return new ChangePasswordDto($password, $email);
    }
}
