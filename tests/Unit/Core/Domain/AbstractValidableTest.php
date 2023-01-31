<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Domain;

use Module\Core\Domain\AbstractValidable;
use Module\Core\Domain\Exception\ValidationException;
use Tests\TestCase;

class AbstractValidableTest extends TestCase
{
	public function testThatAbstractValidableCanBeCreated(): void
	{
		$validable = new class extends AbstractValidable {
			public function validate(): void
			{
				// do nothing
			}
		};
		$this->assertInstanceOf(AbstractValidable::class, $validable);
		$this->assertFalse($validable->hasAnyException());
		$this->assertEquals([], $validable->getExceptions());
	}

	public function testThatAbstractValidableCanBeCreatedWithExceptions(): void
	{
		$validable = new class extends AbstractValidable {
			public function validate(): void
			{
			}
		};
		$validable->addException(new ValidationException('test', 'test'));
		$validable->addException(new ValidationException('test', 'test'));
		$this->assertInstanceOf(AbstractValidable::class, $validable);
		$this->assertTrue($validable->hasAnyException());
		$this->assertEquals(2, count($validable->getExceptions()));
	}
}