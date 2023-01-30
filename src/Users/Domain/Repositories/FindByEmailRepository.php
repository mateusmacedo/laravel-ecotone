<?php

declare(strict_types=1);

namespace Module\Users\Domain\Repositories;

use Module\Users\Domain\Email;
use Module\Users\Domain\UserAggregate;

interface FindByEmailRepository
{
    public function findByEmail(Email $email): ?UserAggregate;
}
