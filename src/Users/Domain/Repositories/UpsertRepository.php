<?php

declare(strict_types=1);

namespace Module\Users\Domain\Repositories;

use Module\Users\Domain\UserAggregate;

interface UpsertRepository
{
    public function upsert(UserAggregate $user): void;
}
