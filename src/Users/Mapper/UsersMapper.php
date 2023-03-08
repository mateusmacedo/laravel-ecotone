<?php

declare(strict_types=1);

namespace Module\Users\Mapper;

use Module\Core\Domain\Errors\DomainError;
use Module\Core\Mapper\IMapper;
use Module\Users\Domain\Email;
use Module\Users\Domain\Password;
use Module\Users\Domain\UserAggregate;

class UsersMapper implements IMapper
{
    public function toDomain(array $rawData): UserAggregate|DomainError
    {
        return UserAggregate::register(
            $rawData['id'],
            Email::create($rawData['email']),
            Password::create($rawData['password'])
        );
    }

    public function toDto($data, ?string $convertTo)
    {
        throw new \Exception('Not implemented');
    }

    public function toPersistence($domainData): ?array
    {
        return [
            'id' => $domainData->getId(),
            'email' => $domainData->getEmail()->value,
            'password' => $domainData->getPassword()->value
        ];
    }
}
