<?php

declare(strict_types=1);

namespace Module\Core\Domain;

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

    protected function addEvent($event)
    {
        $this->domainEvents[] = $event;
    }
}
