<?php

declare(strict_types=1);

namespace Module\Users\Infrastructure\Messaging\Ecotone;

use Ecotone\Messaging\Attribute\MediaTypeConverter;
use Ecotone\Messaging\Conversion\Converter;
use Ecotone\Messaging\Conversion\MediaType;
use Ecotone\Messaging\Handler\TypeDescriptor;

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
        if (!is_object($source)) {
            throw new \InvalidArgumentException('Source must be an object');
        }
        $data = (array) $source;

        return json_encode($data, JSON_THROW_ON_ERROR);
    }
}
