<?php

declare(strict_types=1);

namespace Module\Users\Domain;

use Module\Core\Domain\AbstractValidable;
use Module\Core\Domain\Contracts\Validable;
use Module\Core\Infrastructure\ArraySerialize;
use Module\Core\Infrastructure\FromArray;
use Module\Core\Infrastructure\FromJson;
use Module\Core\Infrastructure\UuidGenerator;
use Module\Users\Application\Dtos\RegisterDto;

class UserAggregate extends AbstractValidable implements ArraySerialize, \JsonSerializable, FromArray, FromJson
{
    private function __construct(
        private string $id,
        private Email $email,
        private Password $password
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'],
            new Email($data['email']),
            new Password($data['password'])
        );
    }

    public static function fromJson(string $json): self
    {
        return self::fromArray(json_decode($json, true));
    }

    public static function register(RegisterDto $dto): self
    {
        return new self(UuidGenerator::generate(), $dto->getEmail(), $dto->getPassword());
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
            'id' => $this->id,
            'email' => $this->email->getValue(),
            'password' => $this->password->getValue(),
        ];
    }

    public function jsonSerialize()
    {
        return $this->arraySerialize();
    }
}
