<?php

declare(strict_types=1);

namespace Module\Core\Domain;

use Module\Core\Domain\Contracts\DomainEvent;

abstract class AggregateRoot extends Entity
{
    private array $domainEvents;

    public function clearEvents(): void
    {
        $this->domainEvents = [];
    }

    public function getEvents(): array
    {
        return $this->domainEvents;
    }

    protected function addEvent(/* DomainEvent */ $event)
    {
        $this->domainEvents[] = $event;
    }
}
