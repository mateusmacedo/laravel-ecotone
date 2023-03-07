<?php

declare(strict_types=1);

namespace Module\Users\Domain\Repository;

use Module\Core\Infrastructure\Database\Contracts\IBaseReaderRepository;
use Module\Core\Infrastructure\Database\Contracts\IBaseWriterRepository;
use Module\Users\Domain\UserAggregate;

interface IUserRepository extends IBaseReaderRepository, IBaseWriterRepository
{
    public function findOne(array $filter): ?UserAggregate;
}
