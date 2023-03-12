<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Infrastructure\Database\Errors;

use Module\Core\Infrastructure\Database\Errors\RepositoryError;
use PHPUnit\Framework\TestCase;

class RepositoryErrorTest extends TestCase
{
    public function testGetError()
    {
        $errorMessage = 'Some error message';
        $error = new RepositoryError($errorMessage);

        $this->assertEquals($errorMessage, $error->getError());
    }
}
