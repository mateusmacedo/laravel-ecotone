<?php

declare(strict_types=1);

namespace Module\Users\Application\Queries;

use Module\Users\Domain\Repositories\FindByEmailRepository;
use Module\Users\Domain\UserAggregate;

class FindByEmailHandler
{
    public function __construct(private FindByEmailRepository $repository)
    {
    }

    public function handle(FindByEmailQuery $query): ?UserAggregate
    {
        return $this->repository->findByEmail($query->getDto()->getEmail());
    }
}
