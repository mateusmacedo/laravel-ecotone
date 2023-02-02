<?php
namespace Module\Users\Mapper;

use Module\Core\Domain\Entity;
use Module\Core\Mapper\IMapper;
use Module\Users\Domain\Email;
use Module\Users\Domain\Password;
use Module\Users\Domain\UserAggregate;

class UsersMapper implements IMapper
{


    /**
     * @param array $rawData
     * @return Entity
     */
    public function toDomain(array $rawData)
    {
        return UserAggregate::register(
            $rawData['uuid'],
            new Email($rawData['email']),
            new Password($rawData['password'])
        );
    }

    /**
     *
     * @param \Module\Core\Domain\Entity $data
     * @param null|string $convertTo
     * @return mixed
     */
    public function toDto($data, ?string $convertTo)
    {
    }

    public function toPersistence($domainData): ?array
    {
        return [
            "uuid"=>$domainData->uuid,
            "email" => $domainData->getEmail()->getValue(),
            "password" => $domainData->getPassword()->getValue()
        ];
    }
}
