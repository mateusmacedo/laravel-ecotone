<?php

declare(strict_types=1);

namespace Module\Users\Application\Commands;

class RegisterCommand
{
    public readonly string $email;
    public readonly string $password;
    public function __construct(mixed $data)
    {
        $this->email = $data['email'] ?? null;
        $this->password = $data['password'] ?? null;
    }
}
