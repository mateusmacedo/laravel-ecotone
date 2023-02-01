<?php

declare(strict_types=1);

namespace Module\Users\Application\Dtos;

use Module\Users\Domain\Email;
use Module\Users\Domain\Password;

class ChangePasswordDto
{
    public function __construct(private Password $newPassword, private Email $email)
    {
    }

    public function getNewPassword(): Password
    {
        return $this->newPassword;
    }
    public function getEmail(): Email
    {
        return $this->email;
    }
}
