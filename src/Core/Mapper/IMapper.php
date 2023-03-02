<?php

declare(strict_types=1);

namespace Module\Core\Mapper;

interface IMapper
{
    public function toDomain(array $rawData);

    public function toDto($data, ?string $convertTo);

    public function toPersistence($domainData): ?array;
}
