<?php

declare(strict_types=1);

namespace Module\Users\Domain\Repositories;

use Module\Users\Domain\UserAggregate;

interface FindByIdRepository
{
    public function findById(string $id): ?UserAggregate;
}
