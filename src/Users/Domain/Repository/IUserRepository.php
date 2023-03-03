<?php

declare(strict_types=1);

namespace Module\Users\Domain\Repository;

use Module\Core\Infrastructure\Database\Contracts\IBaseReaderRepository;
use Module\Core\Infrastructure\Database\Contracts\IBaseWriterRepository;

interface IUserRepository extends IBaseReaderRepository, IBaseWriterRepository
{
}
