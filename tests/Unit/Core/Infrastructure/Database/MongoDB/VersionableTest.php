<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Infrastructure\Database\MongoDB;

use Module\Core\Infrastructure\Database\MongoDB\Versionable;
use PHPUnit\Framework\TestCase;

class VersionableTest extends TestCase
{
    use Versionable;

    public function testGetVersionMethod(): void
    {
        $this->setVersion(2);
        $this->assertEquals(2, $this->getVersion());
    }

    public function testSetVersionMethod(): void
    {
        $this->setVersion(5);
        $this->assertEquals(5, $this->{$this->versionField});
    }

    public function testIncrementVersionMethod(): void
    {
        $this->setVersion(1);
        $this->incrementVersion();
        $this->assertEquals(2, $this->getVersion());
    }

    public function testIsVersionValidMethod(): void
    {
        $this->setVersion(3);
        $this->assertTrue($this->isVersionValid(3));
        $this->assertFalse($this->isVersionValid(2));
    }

    public function testScopeWhereVersionMethod(): void
    {
        $query = $this->getMockBuilder('Jenssegers\Mongodb\Query\Builder')
            ->disableOriginalConstructor()
            ->getMock();
        $version = 4;

        $result = $this->scopeWhereVersion($query, $version);

        $this->assertEquals($query->where($this->versionField, $version), $result);
    }
}
