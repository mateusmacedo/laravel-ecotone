<?php

declare(strict_types=1);

namespace Module\Users\Infrastructure\Messaging\Ecotone;

use Ecotone\Sqs\Configuration\SqsMessageConsumerConfiguration;
use Ecotone\Messaging\Attribute\ServiceContext;

class ConsumerConfiguration
{
	#[ServiceContext]
	public function userRegisteredConsumerConfig(): array
	{
		return [
            SqsMessageConsumerConfiguration::create('sendRegistrationEmail', 'users')
			->withDeclareOnStartup(false)
        ];
	}
}