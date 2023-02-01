<?php

declare(strict_types=1);

namespace Module\Users\Domain;

use Module\Core\Domain\AbstractValidable;
use Module\Core\Infrastructure\UuidGenerator;
use Module\Users\Domain\Email;
use Module\Users\Domain\Password;
use Module\Core\Domain\Contracts\Validable;

class UserAggregate extends AbstractValidable
{
    public function __construct(
        private string $id,
        private Email $email,
        private Password $password
    ) {
    }

    public static function register(Email $email, Password $password): static
    {
        return new self(UuidGenerator::generate(), $email, $password);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPassword(): Password
    {
        return $this->password;
    }

    public function validate(): void
    {
        foreach ($this as $attribute) {
            if (!$attribute instanceof Validable) {
                continue;
            }
            $attribute->validate();
            foreach ($attribute->getExceptions() as $e) {
                $this->addException($e);
            }
        }
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email->getValue(),
            'password' => $this->password->getValue(),
        ];
    }

    public static function fromArray(array $data): static
    {
        return new self(
            $data['id'],
            new Email($data['email']),
            new Password($data['password'])
        );
    }

    public function toJson(): string
    {
        return json_encode($this->toArray());
    }

    public static function fromJson(string $json): static
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
