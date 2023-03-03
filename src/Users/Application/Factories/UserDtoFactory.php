<?php

declare(strict_types=1);

namespace Module\Users\Application\Factories;

use Module\Users\Application\Dtos\FindByEmailDto;
use Module\Users\Application\Dtos\RegisterDto;
use Module\Users\Domain\Email;
use Module\Users\Domain\Password;

class UserDtoFactory
{
    public function registerDto(array $data): RegisterDto
    {
        $email = Email::create($data['email']);
        $password = Password::create($data['password']);
        return new RegisterDto($email, $password);
    }

    public function findByEmailDto(string $data): FindByEmailDto
    {
        $email = new Email($data);
        return new FindByEmailDto($email);
    }
}
