<?php

declare(strict_types=1);

namespace Module\Users\Domain;

use Module\Core\Domain\AbstractValueObjectValidable;
use Module\Core\Domain\Contracts\ValueObject;
use Module\Core\Domain\Exception\ValidationException;

class Email extends AbstractValueObjectValidable
{
    protected string $identifier = 'email';

    public function equals(ValueObject $valueObject): bool
    {
        return $this->getValue() === $valueObject->getValue();
    }

    public function validate(): void
    {
        if (!filter_var($this->getValue(), FILTER_VALIDATE_EMAIL)) {
            $this->addException(new ValidationException('Invalid email', $this->getIdentifier()));
        }
    }
}
