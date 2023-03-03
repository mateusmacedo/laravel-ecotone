<?php

declare(strict_types=1);

namespace Module\Core;

use Module\Core\Domain\Errors\DomainError;
use Module\Core\Infrastructure\Database\Errors\RepositoryError;

class Result
{
    public readonly bool $isError;
    private readonly mixed $error;
    private readonly mixed $value;

    public function __construct(
        bool $isSuccess,
        mixed $value = null,
        mixed $error = null
    ) {
        if ($isSuccess && $error) {
            throw new \ErrorException('OperacaoInvalida: O resultado nao pode ser valido e conter erro.');
        }

        if (!$isSuccess && !$error) {
            throw new \ErrorException('OperacaoInvalida: O resultado deve ser valido ou invalido.');
        }

        $this->error = $error;
        $this->isError = !$isSuccess;
        $this->value = $value;
    }

    public function getValue(): mixed
    {
        if ($this->isError) {
            throw new \ErrorException('para retornar o erro, use a função getError.');
        }
        return $this->value;
    }

    public function getError(): mixed
    {
        return $this->error;
    }

    public static function ok(mixed $value = null): self
    {
        return new self(true, $value);
    }

    public static function fail(mixed $value): self
    {
        return new self(false, null, $value);
    }

    public static function combine(array $results): self
    {
        $errors = [];
        foreach ($results as $key => $result) {
            $error = null;
            if ($result instanceof DomainError) {
                $error = $result->getErrors();
            }
            if ($result instanceof RepositoryError || $result instanceof Result) {
                $error = $result->getError();
            }
            if (null != $error) {
                $errors[] = ['arrayPosition' => $key, 'error' => $error];
            }
        }
        return !empty($errors) ? self::fail($errors) : self::ok();
    }
}
