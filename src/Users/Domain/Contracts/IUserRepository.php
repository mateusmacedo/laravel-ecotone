<?php

declare(strict_types=1);

namespace Module\Users\Domain\Contracts;

use Module\Core\Infrastructure\Database\IBaseReaderRepository;
use Module\Core\Infrastructure\Database\IBaseWriterRepository;

interface IUserRepository extends IBaseReaderRepository, IBaseWriterRepository
{
}
