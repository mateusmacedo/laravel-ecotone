<?php

declare(strict_types=1);

namespace Module\Users\Application\Dtos;

use Module\Core\Infrastructure\ArraySerialize;
use Module\Users\Domain\Email;
use Module\Users\Domain\Password;

class RegisterDto implements ArraySerialize
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

    public function arraySerialize(): array
    {
        return [
            'email' => $this->email->getValue(),
            'password' => $this->password->getValue(),
        ];
    }
}
