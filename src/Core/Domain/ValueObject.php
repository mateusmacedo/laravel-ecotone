<?php

declare(strict_types=1);

namespace Module\Core\Domain;

abstract class ValueObject
{
    protected string $identifier;

    protected function __construct(public readonly mixed $value)
    {
    }
    abstract public function equals(ValueObject $valueObject): bool;
}
