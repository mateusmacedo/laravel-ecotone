<?php

declare(strict_types=1);

namespace Module\Users\Application\Commands;

use Module\Users\Application\Dtos\ChangePasswordDto;

class ChangePasswordCommand
{
    public function __construct(private ChangePasswordDto $passwordDto)
    {
    }

    public function getDto(): ChangePasswordDto
    {
        return $this->passwordDto;
    }
}
