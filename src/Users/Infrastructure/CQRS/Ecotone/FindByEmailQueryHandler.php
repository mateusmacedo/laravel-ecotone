<?php

declare(strict_types=1);

namespace Module\Users\Infrastructure\CQRS\Ecotone;

use Ecotone\Modelling\Attribute\QueryHandler;
use Module\Users\Application\Queries\FindByEmailHandler;
use Module\Users\Application\Queries\FindByEmailQuery;
use Module\Users\Domain\UserAggregate;

class FindByEmailQueryHandler
{
	#[QueryHandler]
	public function handle(FindByEmailQuery $query, FindByEmailHandler $handler): ?UserAggregate
	{
		return $handler->handle($query);
	}
}