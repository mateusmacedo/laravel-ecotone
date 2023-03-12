<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Application\Errors;

use Module\Core\Application\Errors\DataNotFoundError;
use PHPUnit\Framework\TestCase;

class DataNotFoundErrorTest extends TestCase
{
    public function testDataNotFoundErrorInstance()
    {
        $errors = ['Error 1', 'Error 2'];
        $applicationError = new DataNotFoundError($errors);

        $this->assertInstanceOf(DataNotFoundError::class, $applicationError);
    }

    public function testDataNotFoundErrorContent()
    {
        $errors = ['Error 1', 'Error 2'];
        $applicationError = new DataNotFoundError($errors);

        $this->expectException(\ErrorException::class);
        $this->expectExceptionMessage('para retornar o erro, use a função getError.');
        $applicationError->getValue();
        $this->assertEquals($errors, $applicationError->getError());
    }
}
