<?php

declare(strict_types=1);

namespace Module\Core\Domain;

use Module\Core\Infrastructure\UuidGenerator;

abstract class Entity
{
    protected function __construct(private ?string $id = null)
    {
        $this->id = $id ?? UuidGenerator::generate();
    }

    public function getId(): ?string
    {
        return $this->id;
    }
}
