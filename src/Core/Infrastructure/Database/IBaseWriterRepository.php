<?php

declare(strict_types=1);

namespace Module\Core\Infrastructure\Database;

use Module\Core\Domain\Entity;
use Module\Core\Infrastructure\Database\Contracts\RepositoryError;

interface IBaseWriterRepository
{
    public function upsert(Entity $data): RepositoryError|bool;

    public function remove(array $filter): RepositoryError|bool;
}
