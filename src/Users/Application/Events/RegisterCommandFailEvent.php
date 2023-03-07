<?php

declare(strict_types=1);

namespace Module\Users\Application\Events;

use Module\Users\Application\Commands\RegisterCommand;

class RegisterCommandFailEvent
{
    public function __construct(public readonly RegisterCommand $command, public readonly string $error)
    {
    }
}
