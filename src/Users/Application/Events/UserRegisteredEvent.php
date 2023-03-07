<?php

declare(strict_types=1);

namespace Module\Users\Application\Events;

class UserRegisteredEvent
{
    public function __construct(public readonly string $uuid)
    {
    }
}
