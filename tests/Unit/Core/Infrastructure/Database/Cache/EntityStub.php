<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Infrastructure\Database\Cache;

use Module\Core\Domain\Entity;

class EntityStub extends Entity
{
    public function __construct(
        private string $id,
        private string $name,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
