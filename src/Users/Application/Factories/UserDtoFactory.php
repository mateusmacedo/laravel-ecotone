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

    public function findByEmailDto(string $data): FindByEmailDto
    {
        $email = new Email($data);
        return new FindByEmailDto($email);
    }

  public function changeEmailDto(string $userId, array $data): ChangeEmailDto
  {
      return new ChangeEmailDto(
          $userId,
          new Email($data['email']),
      );
  }

    public function changePasswordDto(string $userId, array $data): ChangePasswordDto
    {
        $password = new Password($data['password']);
        return new ChangePasswordDto($userId, $password);
    }
}
