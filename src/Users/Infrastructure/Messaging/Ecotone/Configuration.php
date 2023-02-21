<?php

declare(strict_types=1);

namespace Module\Users\Infrastructure\Messaging\Ecotone;

use Ecotone\Amqp\AmqpBackedMessageChannelBuilder;
use Ecotone\Messaging\Attribute\ServiceContext;
use Ecotone\Messaging\Conversion\MediaType;
use Ecotone\Sqs\SqsBackedMessageChannelBuilder;

class Configuration
{
    #[ServiceContext]
    public function enableSQS(): array
    {
        return [
            SqsBackedMessageChannelBuilder::create('users-aws')
                ->withDefaultConversionMediaType(MediaType::APPLICATION_JSON)
                ->withAutoDeclare(false)
        ];
    }

    #[ServiceContext]
    public function enableRabbiMQ()
    {
        return AmqpBackedMessageChannelBuilder::create('users');
    }
}
