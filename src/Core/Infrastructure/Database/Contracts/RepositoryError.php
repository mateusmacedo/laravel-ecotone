<?php

declare(strict_types=1);

namespace Module\Core\Infrastructure\Database\Contracts;

class RepositoryError
{
    public function __construct(private readonly mixed $error)
    {
    }

    public function getError()
    {
        return $this->error;
    }
}
