<?php

declare(strict_types=1);

namespace Module\Users\Infrastructure\Messaging\Ecotone;

use Ecotone\Messaging\Attribute\ServiceContext;
use Ecotone\Sqs\Configuration\SqsMessagePublisherConfiguration;

class PublisherConfiguration
{
    #[ServiceContext]
    public function userRegisteredPublisherConfig(): SqsMessagePublisherConfiguration
    {
        return SqsMessagePublisherConfiguration::create(queueName: 'users')
          ->withAutoDeclareQueueOnSend(false);
    }
}
