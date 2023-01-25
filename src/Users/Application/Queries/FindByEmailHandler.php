<?php

declare(strict_types=1);

namespace Module\Users\Application\Queries;

use Module\Users\Domain\Contracts\FindByEmailRepository;
use Module\Users\Domain\UserAggregate;
use Module\Users\Application\Queries\FindByEmailQuery;

class FindByEmailHandler
{
	public function __construct(private FindByEmailRepository $repository)
	{
	}

	#[QueryHandler]
	public function handle(FindByEmailQuery $query): ?UserAggregate
	{
		return $this->repository->findByEmail($query->getDto()->getEmail());
	}
}