<?php

declare(strict_types=1);

namespace Module\Users\Application\Commands;

class RegisterCommand
{
    public function __construct(public readonly string $email, public readonly string $password)
    {
    }
}
