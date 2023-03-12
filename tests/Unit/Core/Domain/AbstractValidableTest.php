<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Domain;

use Module\Core\Domain\AbstractValidable;
use Module\Core\Domain\Errors\ValidationException;
use PHPUnit\Framework\TestCase;

class AbstractValidableTest extends TestCase
{
    use AbstractValidable;

    public function setUp(): void
    {
        $this->resetErrors();
    }

    public function tearDown(): void
    {
        $this->resetErrors();
    }

    public function testAddError(): void
    {
        $this->addError(new ValidationException('Name is invalid', 'name'));
        $errors = $this->getErrors();
        $this->assertCount(1, $errors);
        $this->assertInstanceOf(ValidationException::class, $errors[0]);

        $this->addError(new ValidationException('Email is invalid', 'email'));
        $errors = $this->getErrors();
        $this->assertCount(2, $errors);
        $this->assertInstanceOf(ValidationException::class, $errors[1]);
    }

    public function testHasError(): void
    {
        $this->assertFalse($this->hasError());

        $this->addError(new ValidationException('Name is invalid', 'name'));
        $this->assertTrue($this->hasError());
        $this->assertTrue('name' === $this->getErrors()[0]->getIdentifier());
    }

    protected function resetErrors(): void
    {
        $reflection = new \ReflectionClass($this);
        $property = $reflection->getProperty('exceptions');
        $property->setAccessible(true);
        $property->setValue($this, []);
    }
}
