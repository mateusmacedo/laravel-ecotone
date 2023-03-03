<?php

declare(strict_types=1);

namespace Module\Users\Application\Events;

use Module\Core\Infrastructure\Ecotone\Contracts\ISerializeToQueue;

class UserRegisteredEvent implements ISerializeToQueue
{
    public readonly string $uuid;
    public readonly string $email;
    public readonly string $password;

    public function __construct(mixed $data)
    {
        $this->uuid = $data['uuid'] ?? null;
        $this->email = $data['email'] ?? null;
        $this->password = $data['password'] ?? null;
    }

    public function toArray(): array
    {
        return ['uuid' => $this->uuid, 'email' => $this->email, 'password' => $this->password];
    }
}
