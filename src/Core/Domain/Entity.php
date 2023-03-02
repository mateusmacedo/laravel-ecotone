<?php

declare(strict_types=1);

namespace Module\Core\Domain;

use Module\Core\Infrastructure\UuidGenerator;

abstract class Entity
{
    protected function __construct(private ?string $uuid = null)
    {
        $this->uuid = $uuid ?? UuidGenerator::generate();
    }

    public function getUuid()
    {
        return $this->uuid;
    }
}
