<?php

declare(strict_types=1);

namespace Module\Users\Domain;

use ArrayObject;
use Module\Core\Domain\Exception\DomainError;
use Module\Core\Domain\Exception\ValidationException;
use Module\Core\Domain\ValueObject;

class Password extends ValueObject
{

    static function create(mixed $value): self|DomainError
    {
        $errors = self::validate($value);
        if ($errors->count() > 0)
            return new DomainError($errors, 'password');

        return new Password($value);
    }
    public function equals(ValueObject $valueObject): bool
    {
        return $this->value === $valueObject->value;
    }

    private static function validate(mixed $value): ArrayObject
    {
        $errors = new ArrayObject();
        if (strlen($value) < 8) {
            $errors->append('Password must be at least 8 characters');
        }

        return $errors;
    }
}
