<?php

declare(strict_types=1);

namespace Module\Users\Application\Dtos;

use Module\Users\Domain\Email;
use Module\Users\Domain\Password;

class RegisterDto
{
    public function __construct(private Email $email, private Password $password)
    {
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPassword(): Password
    {
        return $this->password;
    }
}
