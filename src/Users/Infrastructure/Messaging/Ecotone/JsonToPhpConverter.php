<?php

declare(strict_types=1);

namespace Module\Users\Infrastructure\Messaging\Ecotone;

use Ecotone\Messaging\Attribute\MediaTypeConverter;
use Ecotone\Messaging\Conversion\Converter;
use Ecotone\Messaging\Conversion\MediaType;
use Ecotone\Messaging\Handler\TypeDescriptor;
use Module\Users\Application\Commands\ChangePasswordCommand;
use Module\Users\Application\Commands\RegisterCommand;
use Module\Users\Application\Events\EmailChangedEvent;
use Module\Users\Application\Events\UserRegisteredEvent;
use Module\Users\Application\Factories\UserCommandQueryFactory;
use Module\Users\Application\Factories\UserDtoFactory;

#[MediaTypeConverter]
class JsonToPhpConverter implements Converter
{
    public function matches(TypeDescriptor $sourceType, MediaType $sourceMediaType, TypeDescriptor $targetType, MediaType $targetMediaType): bool
    {
        return $sourceMediaType->isCompatibleWith(MediaType::createApplicationJson())
        && $targetMediaType->isCompatibleWith(MediaType::createApplicationXPHP());
    }

    public function convert($source, TypeDescriptor $sourceType, MediaType $sourceMediaType, TypeDescriptor $targetType, MediaType $targetMediaType)
    {
        $data = \json_decode($source, true, 512, JSON_THROW_ON_ERROR);
        switch ($targetType->getTypeHint()) {
            case RegisterCommand::class:
                $dtoFactory = app(UserDtoFactory::class);
                $commandQueryFactory = app(UserCommandQueryFactory::class);
                $dto = $dtoFactory->registerDto($data);
                return $commandQueryFactory->registerCommand($dto);
            case ChangeEmailCommand::class:
                $dtoFactory = app(UserDtoFactory::class);
                $commandQueryFactory = app(UserCommandQueryFactory::class);
                $dto = $dtoFactory->changeEmailDto($data);
                return $commandQueryFactory->changeEmailCommand($dto);
            case ChangePasswordCommand::class:
                $dtoFactory = app(UserDtoFactory::class);
                $commandQueryFactory = app(UserCommandQueryFactory::class);
                $dto = $dtoFactory->changePasswordDto($data);
                return $commandQueryFactory->changePasswordCommand($dto);
            case UserRegisteredEvent::class:
                return UserRegisteredEvent::fromArray($data);
            case EmailChangedEvent::class:
                return EmailChangedEvent::fromArray($data);
            default:
                throw new \InvalidArgumentException('Unknown conversion type');
        }
    }
}
