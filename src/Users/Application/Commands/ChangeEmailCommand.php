<?php

declare(strict_types=1);

namespace Module\Users\Application\Commands;

use Module\Core\Infrastructure\ArraySerialize;
use Module\Users\Application\Dtos\ChangeEmailDto;

class ChangeEmailCommand implements ArraySerialize
{
    public function __construct(private ChangeEmailDto $dto)
    {
    }

    public function getDto(): ChangeEmailDto
    {
        return $this->dto;
    }

    public function arraySerialize(): array
    {
        return [
            'dto' => $this->dto->arraySerialize()
        ];
    }
}
