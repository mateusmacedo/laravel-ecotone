<?php

declare(strict_types=1);

namespace Module\Core\Domain\Contracts;

use Module\Core\Domain\Exception\ValidationException;

interface Validable
{
    public function validate(): void;
    public function addException(ValidationException $e);
    public function hasAnyException(): bool;
    public function getExceptions(): array;
}
