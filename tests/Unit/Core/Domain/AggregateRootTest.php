<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Domain;

use PHPUnit\Framework\TestCase;

class AggregateRootTest extends TestCase
{
    private $aggregateRoot;

    protected function setUp(): void
    {
        $this->aggregateRoot = AggregateRootStub::createNew();
    }

    public function testItShouldAddEventsToArray(): void
    {
        $this->aggregateRoot->publishDomainEvent('First Event');

        $events = $this->aggregateRoot->getEvents();
        $this->assertCount(1, $events);
        $this->assertEquals($events[0], 'First Event');
    }

    public function testItShouldClearAllEventsFromArray(): void
    {
        $this->aggregateRoot->publishDomainEvent('First Event');
        $this->aggregateRoot->publishDomainEvent('Second Event');

        $this->aggregateRoot->clearEvents();

        $events = $this->aggregateRoot->getEvents();
        $this->assertEmpty($events);
    }

    public function testItShouldAssertAggregateId()
    {
        $this->assertNotNull($this->aggregateRoot->getId());
    }
}
