<?php

declare(strict_types=1);

namespace Tests\Unit\Core;

use Module\Core\Domain\Errors\DomainError;
use Module\Core\Result;
use PHPUnit\Framework\TestCase;

class ResultTest extends TestCase
{
    public function testOk(): void
    {
        $result = Result::ok(42);
        $this->assertFalse($result->isError);
        $this->assertEquals(42, $result->getValue());
    }

    public function testFail(): void
    {
        $result = Result::fail(['error' => 'Algo deu errado']);
        $this->assertTrue($result->isError);
        $this->assertEquals(['error' => 'Algo deu errado'], $result->getError());
    }

    public function testCombineAllSuccess(): void
    {
        $results = [
            Result::ok('foo'),
            Result::ok('bar'),
        ];

        $result = Result::combine($results);

        $this->assertFalse($result->isError);
        $this->assertNull($result->getError());
    }

    public function testCombineOneFailure(): void
    {
        $results = [
            Result::ok('foo'),
            Result::fail(['error' => 'Algo deu errado']),
        ];

        $result = Result::combine($results);

        $this->assertTrue($result->isError);
        $this->assertEquals([['arrayPosition' => 1, 'error' => ['error' => 'Algo deu errado']]], $result->getError());
    }

    public function testCombineMultipleFailures(): void
    {
        $results = [
            Result::fail(['error' => 'Algo deu errado']),
            Result::ok('bar'),
            Result::fail(['error' => 'Outra coisa deu errado']),
        ];

        $result = Result::combine($results);

        $this->assertTrue($result->isError);
        $this->assertEquals([
            ['arrayPosition' => 0, 'error' => ['error' => 'Algo deu errado']],
            ['arrayPosition' => 2, 'error' => ['error' => 'Outra coisa deu errado']]
        ], $result->getError());
    }

    public function testCombineWithDomainError(): void
    {
        $results = [
            Result::ok('foo'),
            new DomainError(new \ArrayObject(['error' => 'Algo deu errado'])),
            Result::fail(['error' => 'Outra coisa deu errado']),
        ];

        $result = Result::combine($results);

        $this->assertTrue($result->isError);
        $this->assertEquals([
            ['arrayPosition' => 1, 'error' => new \ArrayObject(['error' => 'Algo deu errado'])],
            ['arrayPosition' => 2, 'error' => ['error' => 'Outra coisa deu errado']]
        ], $result->getError());
    }

    public function testOkWithError(): void
    {
        $this->expectException(\ErrorException::class);
        $this->expectExceptionMessage('OperacaoInvalida: O resultado nao pode ser valido e conter erro.');

        new Result(true, 'value', 'error');
    }

    public function testFailWithoutError(): void
    {
        $this->expectException(\ErrorException::class);
        $this->expectExceptionMessage('OperacaoInvalida: O resultado deve ser valido ou invalido.');

        new Result(false, null);
    }

    public function testGetError(): void
    {
        $result = Result::fail(['error' => 'Algo deu errado']);
        $this->assertEquals(['error' => 'Algo deu errado'], $result->getError());
    }

    public function testGetValueWithFail(): void
    {
        $result = Result::fail(['error' => 'Algo deu errado']);
        $this->expectException(\ErrorException::class);
        $this->expectExceptionMessage('para retornar o erro, use a função getError.');

        $result->getValue();
    }

    public function testGetValueWithSuccess(): void
    {
        $result = Result::ok('foo');
        $this->assertEquals('foo', $result->getValue());
    }

    public function testDomainErrorWithNameExists(): void
    {
        $domainError = new DomainError(new \ArrayObject(['error' => 'Algo deu errado']), 'ExistingName');
        $result = Result::fail($domainError);

        $this->assertEquals(
            ['ExistingName' => ['error' => 'Algo deu errado']],
            $result->getError()->getErrors()->getArrayCopy()
        );
    }
}
