<?php

declare(strict_types=1);

namespace Module\Core\Domain;

use Module\Core\Domain\Exception\ValidationException;

trait AbstractValidable
{
    private static array $exceptions = [];

    public static function addError(ValidationException $e): void
    {
        self::$exceptions[] = $e;
    }

    public function hasError(): bool
    {
        return count($this->exceptions) > 0;
    }

    public function getErrors(): array
    {
        return $this->exceptions;
    }
}
