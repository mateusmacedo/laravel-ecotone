<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Domain\Exception;

use Module\Core\Domain\Exception\ValidationException;
use Module\Core\Domain\Exception\ValidationExceptions;
use Tests\TestCase;

class ValidationExceptionsTest extends TestCase
{
	public function testThatValidationExceptionsCanBeCreated(): void
	{
		$exceptions = new ValidationExceptions();
		$this->assertInstanceOf(ValidationExceptions::class, $exceptions);
		$this->assertEquals([], $exceptions->getAll());
		$this->assertEquals(0, $exceptions->count());
		$this->assertNull($exceptions->getCurrent());
	}

	public function testThatValidationExceptionsCanBeCreatedWithExceptions(): void
	{
		$exceptionCollection = [
			new ValidationException('test1', 'test1'),
			new ValidationException('test2', 'test2'),
		];
		$exceptions = new ValidationExceptions($exceptionCollection);
		$this->assertInstanceOf(ValidationExceptions::class, $exceptions);
		$this->assertEquals($exceptionCollection, $exceptions->getAll());
		$this->assertEquals(2, $exceptions->count());
		$this->assertInstanceOf(ValidationException::class, $exceptions->getCurrent());
		$this->assertEquals('test1', $exceptions->getCurrent()->getIdentifier());
		$this->assertEquals('test1', $exceptions->getCurrent()->getMessage());
		$this->assertEquals(['test1' => ['test1'], 'test2' => ['test2']], $exceptions->extractErrorMessages());
	}
}