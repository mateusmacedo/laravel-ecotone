<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Domain;

use Tests\TestCase;
use Tests\Unit\Core\Domain\Stubs\AbstractValueObjectValidableStub;

class AbstractValueObjectValidableTest extends TestCase
{
    public function testThatCanPerformValidation(): void
    {
        $sut = new AbstractValueObjectValidableStub('foo');
        $this->assertEquals(AbstractValueObjectValidableStub::class, $sut->getIdentifier());
        $this->assertEquals('foo', $sut->getValue());
        $this->assertTrue($sut->equals(new AbstractValueObjectValidableStub('foo')));
    }
}
