<?php

declare(strict_types=1);

namespace Module\Users\Application\Commands;

use Module\Core\Infrastructure\ArraySerialize;
use Module\Users\Application\Dtos\ChangePasswordDto;

class ChangePasswordCommand implements ArraySerialize
{
    public function __construct(private ChangePasswordDto $dto)
    {
    }

    public function getDto(): ChangePasswordDto
    {
        return $this->dto;
    }

    public function arraySerialize(): array
    {
        return [
            'dto' => $this->dto->arraySerialize(),
        ];
    }
}
