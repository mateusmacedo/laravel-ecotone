<?php

declare(strict_types=1);

namespace Module\Users\Domain;

use Module\Core\Domain\AbstractValueObjectValidable;
use Module\Core\Domain\Contracts\ValueObject;
use Module\Core\Domain\Exception\ValidationException;

class Password extends AbstractValueObjectValidable
{
    protected string $identifier = 'password';

    public function equals(ValueObject $valueObject): bool
    {
        return $this->getValue() === $valueObject->getValue();
    }

    public function validate(): void
    {
        if (strlen($this->getValue()) < 8) {
            $this->addException(new ValidationException('Password must be at least 8 characters', $this->getIdentifier()));
        }
    }
}
