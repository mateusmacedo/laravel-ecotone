<?php

declare(strict_types=1);

namespace Module\Users\Domain;

use Module\Core\Domain\AggregateRoot;
use Module\Core\Domain\Errors\DomainError;

class UserAggregate extends AggregateRoot
{
    public function __construct(
        ?string $id,
        private Email $email,
        private Password $password
    ) {
        parent::__construct($id);
    }

    public static function register(?string $id, Email|DomainError $email, Password|DomainError $password): UserAggregate|DomainError
    {
        $errors = self::validate($id, $email);
        if ($errors->count() > 0) {
            return new DomainError($errors, 'userAggregatte');
        }

        $instance = new self($id, $email, $password);
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

    private static function validate($id = null, $email = null): \ArrayObject
    {
        $errors = new \ArrayObject();
        if (is_numeric($id)) {
            $errors->append('id nao e valido');
        }
        if ($email instanceof DomainError && $email->getErrors()->count() > 0) {
            foreach ($email->getErrors() as $erEmail) {
                $errors->append($erEmail);
            }
        }
        return $errors;
    }
}
