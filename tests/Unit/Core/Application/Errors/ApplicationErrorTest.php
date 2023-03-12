<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Application\Errors;

use Module\Core\Application\Errors\ApplicationError;
use PHPUnit\Framework\TestCase;

class ApplicationErrorTest extends TestCase
{
    public function testApplicationErrorInstance()
    {
        $errors = ['Error 1', 'Error 2'];
        $applicationError = new ApplicationError($errors);

        $this->assertInstanceOf(ApplicationError::class, $applicationError);
    }

    public function testApplicationErrorContent()
    {
        $errors = ['Error 1', 'Error 2'];
        $applicationError = new ApplicationError($errors);

        $this->expectException(\ErrorException::class);
        $this->expectExceptionMessage('para retornar o erro, use a função getError.');
        $applicationError->getValue();
        $this->assertEquals($errors, $applicationError->getError());
    }
}
