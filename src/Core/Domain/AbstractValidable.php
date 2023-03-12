<?php

declare(strict_types=1);

namespace Module\Core\Domain;

use Module\Core\Domain\Errors\ValidationException;

trait AbstractValidable
{
    private static array $exceptions = [];

    public static function addError(ValidationException $e): void
    {
        self::$exceptions[] = $e;
    }

    public static function hasError(): bool
    {
        return count(self::$exceptions) > 0;
    }

    public static function getErrors(): array
    {
        return self::$exceptions;
    }
}
