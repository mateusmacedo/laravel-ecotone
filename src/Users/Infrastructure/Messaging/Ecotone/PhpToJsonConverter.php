<?php

declare(strict_types=1);

namespace Module\Users\Infrastructure\Messaging\Ecotone;

use Ecotone\Messaging\Attribute\MediaTypeConverter;
use Ecotone\Messaging\Conversion\Converter;
use Ecotone\Messaging\Conversion\MediaType;
use Ecotone\Messaging\Handler\TypeDescriptor;
use PHPUnit\Framework\InvalidArgumentException;

#[MediaTypeConverter]
class PhpToJsonConverter implements Converter
{
    public function matches(TypeDescriptor $sourceType, MediaType $sourceMediaType, TypeDescriptor $targetType, MediaType $targetMediaType): bool
    {
        return $sourceMediaType->isCompatibleWith(MediaType::createApplicationXPHP())
        && $targetMediaType->isCompatibleWith(MediaType::createApplicationJson());
    }

    public function convert($source, TypeDescriptor $sourceType, MediaType $sourceMediaType, TypeDescriptor $targetType, MediaType $targetMediaType)
    {
        if ($source instanceof JsonSerializable) {
            return json_encode($source, JSON_THROW_ON_ERROR);
        }
        throw new InvalidArgumentException("Can't convert " . get_class($source) . ' to json');
    }
}
