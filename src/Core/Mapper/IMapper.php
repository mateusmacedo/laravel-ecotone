<?php
namespace Module\Core\Mapper;

interface IMapper
{
    function toDomain(array $rawData);

    function toDto($data, ?string $convertTo);

    function toPersistence($domainData): ?array;
}
