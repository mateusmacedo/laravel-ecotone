<?php

declare(strict_types=1);

namespace Module\Users\Application\Dtos;

use Module\Core\Domain\Exception\DomainError;
use Module\Core\Infrastructure\ArraySerialize;
use Module\Users\Domain\Email;
use Module\Users\Domain\Password;

class RegisterDto implements ArraySerialize
{
    public function __construct(private Email|DomainError $email, private Password|DomainError $password)
    {
    }

    public function getEmail(): Email|DomainError
    {
        return $this->email;
    }

    public function getPassword(): Password|DomainError
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
