<?php

declare(strict_types=1);

namespace Module\Users\Application\Commands;
use Module\Core\Infrastructure\Ecotone\Contracts\ISerializeToQueue;

class RegisterCommand implements ISerializeToQueue
{
    public readonly string $email;
    public readonly string $password;
    public function __construct(mixed $data)
    {
        $this->email = $data['email'] ?? null;
        $this->password = $data['password'] ?? null;
    }

    public function toArray(): array
    {
        return ['email'=>$this->email,'password'=>$this->password];
    }
}
