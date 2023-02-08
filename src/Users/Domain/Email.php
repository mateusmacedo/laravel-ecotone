<?php

declare(strict_types=1);

namespace Module\Users\Domain;

use ArrayObject;
use Module\Core\Domain\Exception\DomainError;
use Module\Core\Domain\Exception\ValidationException;
use Module\Core\Domain\ValueObject;

class Email extends ValueObject
{


    protected function __construct(public readonly mixed $value)
    {
    }

    static function create(mixed $value): self|DomainError
    {
        $errors = self::validate($value);
        if ($errors->count() > 0)
            return new DomainError($errors);
        return new Email($value);
    }

    public function equals(ValueObject $valueObject): bool
    {
        return $this->value === $valueObject;
    }

    private static function validate(mixed $value): ArrayObject
    {
        $errors = new ArrayObject();
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $errors->append('Invalid email');
        }

        return $errors;
    }
}
