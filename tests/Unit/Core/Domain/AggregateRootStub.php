<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Domain;

use Module\Core\Domain\AggregateRoot;

class AggregateRootStub extends AggregateRoot
{
    public static function createNew(): self
    {
        return new self();
    }

    public function publishDomainEvent($event)
    {
        $this->addEvent($event);
    }
}
