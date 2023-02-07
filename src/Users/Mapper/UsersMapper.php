<?php
namespace Module\Users\Mapper;

use Module\Core\Domain\Entity;
use Module\Core\Domain\Exception\DomainError;
use Module\Core\Mapper\IMapper;
use Module\Users\Domain\Email;
use Module\Users\Domain\Password;
use Module\Users\Domain\UserAggregate;

class UsersMapper implements IMapper
{

    public function toDomain(array $rawData): UserAggregate|DomainError
    {
        return UserAggregate::register(
            $rawData['uuid'],
            Email::create($rawData['email']),
            Password::create($rawData['password'])
        );
    }

    public function toDto($data, ?string $convertTo)
    {
    }

    public function toPersistence($domainData): ?array
    {
        return [
            "uuid" => $domainData->uuid,
            "email" => $domainData->email->value,
            "password" => $domainData->password->value
        ];
    }
}
