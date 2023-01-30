<?php

declare(strict_types=1);

namespace Module\Users\Infrastructure\Messaging\Ecotone;

use Ecotone\Messaging\Attribute\ServiceContext;
use Ecotone\Messaging\Endpoint\PollingMetadata;
use Ecotone\Sqs\SqsBackedMessageChannelBuilder;
use Module\Users\Application\Events\UserRegisteredHandler;

class Configuration
{
    #[ServiceContext]
    public function enableSQS(): array
    {
        return [
            SqsBackedMessageChannelBuilder::create('users')
            ->withAutoDeclare(false)
            ->withDefaultConversionMediaType('application/json')
        ];
    }
}