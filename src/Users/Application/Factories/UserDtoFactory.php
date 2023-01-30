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
        $email = new Email($data['email']);
        $password = new Password($data['password']);
        return new RegisterDto($email, $password);
    }

    public function findByEmailDto(array $data): FindByEmailDto
    {
        $email = new Email($data['email']);
        return new FindByEmailDto($email);
    }
}
