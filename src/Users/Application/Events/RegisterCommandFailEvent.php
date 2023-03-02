<?php

declare(strict_types=1);

namespace Module\Users\Application\Events;

use Module\Users\Application\Commands\RegisterCommand;

class RegisterCommandFailEvent
{
    public function __construct(private readonly RegisterCommand $command, private readonly string $error)
    {
    }

    public function getCommand(): RegisterCommand
    {
        return $this->command;
    }

    public function getError(): string
    {
        return $this->error;
    }
}
