<?php

declare(strict_types=1);

namespace Module\Users\Infrastructure\Messaging\Ecotone;

use Ecotone\Messaging\Attribute\ServiceContext;
use Ecotone\Sqs\Configuration\SqsMessagePublisherConfiguration;
use Module\Users\Application\Events\UserRegisteredHandler;
use Ecotone\Messaging\MessagePublisher;

class PublisherConfiguration
{
    #[ServiceContext]
    public function userRegisteredPublisherConfig(): SqsMessagePublisherConfiguration
    {
        return SqsMessagePublisherConfiguration::create(queueName: 'users')
          ->withAutoDeclareQueueOnSend(false);
    }
}
