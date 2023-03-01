<?php

declare(strict_types=1);

namespace Module\Users\Infrastructure\Messaging\Ecotone;

use Ecotone\Messaging\Attribute\MediaTypeConverter;
use Ecotone\Messaging\Conversion\Converter;
use Ecotone\Messaging\Conversion\MediaType;
use Ecotone\Messaging\Handler\TypeDescriptor;
use Module\Core\Infrastructure\Ecotone\Contracts\ISerializeToQueue;

#[MediaTypeConverter]
class PhpToJsonConverter implements Converter
{
    public function matches(TypeDescriptor $sourceType, MediaType $sourceMediaType, TypeDescriptor $targetType, MediaType $targetMediaType): bool
    {
        return $sourceMediaType->isCompatibleWith(MediaType::createApplicationXPHP())
        && ($targetMediaType->isCompatibleWith(MediaType::createApplicationJson())
        || $targetMediaType->isCompatibleWith(MediaType::createTextPlain()));
    }

    public function convert($source, TypeDescriptor $sourceType, MediaType $sourceMediaType, TypeDescriptor $targetType, MediaType $targetMediaType)
    {
        if (!$sourceType->isClassOfType(ISerializeToQueue::class)) {
            throw new \InvalidArgumentException('o comando enviado via bus deve implementar a interface ' . ISerializeToQueue::class);
        }

        return json_encode($source->toArray(), JSON_THROW_ON_ERROR);
    }
}
