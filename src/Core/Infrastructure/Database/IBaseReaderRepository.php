<?php

declare(strict_types=1);

namespace Module\Core\Infrastructure\Database;

use Module\Core\Domain\Entity;
use Module\Core\Infrastructure\Database\Contracts\ListProps;
use Module\Core\Infrastructure\Database\Contracts\ListResponse;
use Module\Core\Infrastructure\Database\Contracts\RepositoryError;

interface IBaseReaderRepository
{
    public function list(ListProps $props): ListResponse|RepositoryError;

    public function findOne(array $filter): Entity|RepositoryError|null;
}
