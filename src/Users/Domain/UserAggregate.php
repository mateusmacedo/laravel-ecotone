<?php

declare(strict_types=1);

namespace Module\Users\Domain;

use Barryvdh\Debugbar\Facades\Debugbar;
use Module\Core\Domain\AbstractValidable;
use Module\Core\Domain\AggregateRoot;
use Module\Core\Domain\Entity;
use Module\Core\Domain\Exception\ValidationException;
use Module\Core\Infrastructure\UuidGenerator;
use Module\Users\Application\Dtos\RegisterDto;


class UserAggregate extends Entity
{
    public function __construct(
        ?string $id,
        private Email $email,
        private Password $password
    )
    {
        parent::__construct($id);
    }

    public static function register(?string $uuid, Email $email, Password $password): static
    {
        return new self(null, $email, $password);
    }

    public function getId(): string
    {
        return $this->uuid;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPassword(): Password
    {
        return $this->password;
    }

    public function changeEmail(Email $newEmail)
    {
        $this->email = $newEmail;
    }

    public function changePassword(Password $password): void
    {
        $this->password = $password;
    }

    public function validate(): void
    {
        $attributes = new \ArrayObject($this);
        $iterator = $attributes->getIterator();
        while ($iterator->valid()) {
            $attribute = $iterator->current();
            if (!$attribute instanceof Validable) {
                continue;
            }
            $attribute->validate();
            foreach ($attribute->getExceptions() as $e) {
                $this->addException($e);
            }
        }
    }

    public function arraySerialize(): array
    {
        return [
            'uuid' => $this->uuid,
            'email' => $this->email->getValue(),
            'password' => $this->password->getValue(),
        ];
    }

    public function jsonSerialize()
    {
        return new self(
            $data['uuid'],
            new Email($data['email']),
            new Password($data['password'])
        );
    }

    public function toJson(): string
    {
        return json_encode($this->toArray());
    }

    public static function fromJson(string $json): self
    {
        return self::fromArray(json_decode($json, true));
    }

    public function changeEmail(Email $newEmail)
    {
        $this->email = $newEmail;
    }

    public function changePassword(Password $password): void
    {
        $this->password = $password;
    }
}
