<?php

declare(strict_types=1);

namespace Module\Users\Domain;

use Module\Core\Domain\AggregateRoot;
use Module\Core\Domain\Errors\DomainError;

class UserAggregate extends AggregateRoot
{
    public function __construct(
        ?string $uuid,
        private Email $email,
        private Password $password
    ) {
        parent::__construct($uuid);
    }

    public static function register(?string $uuid, Email|DomainError $email, Password|DomainError $password): UserAggregate|DomainError
    {
        $errors = self::validate($uuid, $email);
        if ($errors->count() > 0) {
            return new DomainError($errors, 'userAggregatte');
        }

        $instance = new self($uuid, $email, $password);
        $instance->addEvent(['deu_bom' => 'huehuebrbr']);

        return $instance;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPassword(): Password
    {
        return $this->password;
    }

    private static function validate($uuid = null, $email = null): \ArrayObject
    {
        $errors = new \ArrayObject();
        if (is_numeric($uuid)) {
            $errors->append('uuid nao e valido');
        }
        if ($email instanceof DomainError && $email->getErrors()->count() > 0) {
            foreach ($email->getErrors() as $erEmail) {
                $errors->append($erEmail);
            }
        }
        return $errors;
    }
}
