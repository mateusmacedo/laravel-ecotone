<?php

declare(strict_types=1);

namespace Module\Users\Application\Dtos;

use Module\Users\Domain\Email;

class ChangeEmailDto
{
    public function __construct(
        private Email $currentEmail,
        private Email $newEmail,
    ) {
    }

    public function getCurrentEmail(): Email
    {
        return $this->currentEmail;
    }

    public function getNewEmail(): Email
    {
        return $this->newEmail;
    }
}
