<?php

declare(strict_types=1);

namespace Module\Core\Domain;

use Module\Core\Domain\Contracts\ValueObject;

abstract class AbstractValueObjectValidable extends AbstractValidable implements ValueObject
{
    protected string $identifier;

    public function __construct(protected mixed $value)
    {
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    abstract public function equals(ValueObject $valueObject): bool;
}
