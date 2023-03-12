<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Domain;

use Module\Core\Domain\Errors\ValidationException;
use Module\Core\Domain\Errors\ValidationExceptions;
use PHPUnit\Framework\TestCase;

class ValidationExceptionsTest extends TestCase
{
    public function testAdd()
    {
        $validationExceptions = new ValidationExceptions();

        $validationExceptions->add(new ValidationException('Name is invalid', 'name'));
        $this->assertCount(1, $validationExceptions->getAll());

        $validationExceptions->add(new ValidationException('Email is invalid', 'email'));
        $this->assertCount(2, $validationExceptions->getAll());
    }

    public function testGetAll()
    {
        $exception1 = new ValidationException('Name is invalid', 'name');
        $exception2 = new ValidationException('Email is invalid', 'email');

        $validationExceptions = new ValidationExceptions([$exception1, $exception2]);

        $all = $validationExceptions->getAll();
        $this->assertCount(2, $all);
        $this->assertSame($exception1, $all[0]);
        $this->assertSame($exception2, $all[1]);
    }

    public function testCount()
    {
        $validationExceptions = new ValidationExceptions([
            new ValidationException('Name is invalid', 'name'),
            new ValidationException('Email is invalid', 'email')
        ]);

        $this->assertSame(2, $validationExceptions->count());
    }

    public function testGetCurrent()
    {
        $exception1 = new ValidationException('Name is invalid', 'name');
        $exception2 = new ValidationException('Email is invalid', 'email');

        $validationExceptions = new ValidationExceptions([$exception1, $exception2]);
        $this->assertSame($exception1, $validationExceptions->getCurrent());

        $validationExceptions->nextElement();
        $this->assertSame($exception2, $validationExceptions->getCurrent());

        $nextCallResult = $validationExceptions->nextElement();
        $this->assertNull($validationExceptions->getCurrent());
        $this->assertFalse($nextCallResult);
    }

    public function testExtractErrorMessages()
    {
        $validationExceptions = new ValidationExceptions([
            new ValidationException('Name is invalid', 'name'),
            new ValidationException('Email is already in use', 'email'),
            new ValidationException('Username must contain only letters and numbers', 'username'),
            new \RuntimeException('Unexpected error')
        ]);

        $errorMessages = $validationExceptions->extractErrorMessages();

        $this->assertCount(3, $errorMessages);
        $this->assertArrayHasKey('name', $errorMessages);
        $this->assertArrayHasKey('email', $errorMessages);
        $this->assertArrayHasKey('username', $errorMessages);
        $this->assertSame(['Name is invalid'], $errorMessages['name']);
        $this->assertSame(['Email is already in use'], $errorMessages['email']);
        $this->assertSame(['Username must contain only letters and numbers'], $errorMessages['username']);
    }
}
