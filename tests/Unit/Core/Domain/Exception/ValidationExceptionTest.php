<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Domain\Exception;

use Module\Core\Domain\Exception\ValidationException;
use Tests\TestCase;

class ValidationExceptionTest extends TestCase
{
    public function testThatValidationExceptionCanBeCreated(): void
    {
        $exception = new ValidationException('test', 'test');
        $this->assertInstanceOf(ValidationException::class, $exception);
        $this->assertEquals('test', $exception->getIdentifier());
        $this->assertEquals('test', $exception->getMessage());
    }
}
