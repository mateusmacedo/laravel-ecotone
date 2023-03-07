<?php

declare(strict_types=1);

namespace Module\Users\Application\Queries;

use Module\Users\Domain\Repository\IUserRepository;
use Module\Users\Domain\UserAggregate;

class FindByEmailHandler
{
    public function __construct(private IUserRepository $repository)
    {
    }

    public function handle(FindByEmailQuery $query): ?UserAggregate
    {
        return $this->repository->findOne(['email' => $query->email]);
    }
}
