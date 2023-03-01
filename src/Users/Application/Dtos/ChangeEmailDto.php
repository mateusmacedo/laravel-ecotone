<?php

declare(strict_types=1);

namespace Module\Users\Application\Dtos;

use Module\Core\Infrastructure\ArraySerialize;
use Module\Users\Domain\Email;

class ChangeEmailDto implements ArraySerialize
{
    public function __construct(
        private string $userId,
        private Email $email,
    ) {
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function arraySerialize(): array
    {
        return [
            'userId' => $this->userId,
            'email' => $this->email->getValue(),
        ];
    }
}
