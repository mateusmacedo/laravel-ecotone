<?php

declare(strict_types=1);

namespace Module\Users\Application\Dtos;

use Module\Core\Infrastructure\ArraySerialize;
use Module\Users\Domain\Password;

class ChangePasswordDto implements ArraySerialize
{
    public function __construct(private string $userId, private Password $password)
    {
    }

    public function getPassword(): Password
    {
        return $this->password;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function arraySerialize(): array
    {
        return [
            'userId' => $this->userId,
            'password' => $this->password->getValue(),
        ];
    }
}
