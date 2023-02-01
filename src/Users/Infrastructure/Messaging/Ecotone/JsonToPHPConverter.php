<?php

declare(strict_types=1);

namespace Module\Users\Infrastructure\Messaging\Ecotone;

use Ecotone\Messaging\Attribute\MediaTypeConverter;
use Ecotone\Messaging\Conversion\Converter;
use Ecotone\Messaging\Conversion\MediaType;
use Ecotone\Messaging\Handler\TypeDescriptor;
use Module\Users\Application\Events\EmailChangedEvent;
use Module\Users\Application\Events\UserRegisteredEvent;

#[MediaTypeConverter]
class JsonToPHPConverter implements Converter
{
    public function matches(TypeDescriptor $sourceType, MediaType $sourceMediaType, TypeDescriptor $targetType, MediaType $targetMediaType): bool
    {
        return $sourceMediaType->isCompatibleWith(MediaType::createApplicationJson()) // if source media type is JSON
        && $targetMediaType->isCompatibleWith(MediaType::createApplicationXPHP()); // and target media type is PHP
    }

    public function convert($source, TypeDescriptor $sourceType, MediaType $sourceMediaType, TypeDescriptor $targetType, MediaType $targetMediaType)
    {
        $data = \json_decode($source, true, 512, JSON_THROW_ON_ERROR);
        switch ($targetType->getTypeHint()) {
            case UserRegisteredEvent::class:{
                return UserRegisteredEvent::fromArray($data);
            }
            case EmailChangedEvent::class:{
                return EmailChangedEvent::fromArray($data);
            }
            default:{
                throw new \InvalidArgumentException("Unknown conversion type");
            }
        }
    }
}
