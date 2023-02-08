<?php

declare(strict_types=1);

namespace Module\Core\Domain;

abstract class ValueObject
{
    protected string $identifier;
    abstract public function equals(ValueObject $valueObject): bool;
}
