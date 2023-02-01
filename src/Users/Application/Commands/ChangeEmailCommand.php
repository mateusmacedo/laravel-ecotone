<?php

declare(strict_types=1);

namespace Module\Users\Application\Commands;

use Module\Users\Application\Dtos\ChangeEmailDto;

class ChangeEmailCommand
{
    public function __construct(private ChangeEmailDto $dto)
    {
    }

    public function getDto(): ChangeEmailDto
    {
        return $this->dto;
    }
}
