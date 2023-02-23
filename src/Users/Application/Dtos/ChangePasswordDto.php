<?php

declare(strict_types=1);

namespace Module\Users\Application\Dtos;

use Module\Users\Domain\Password;

class ChangePasswordDto
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
}
