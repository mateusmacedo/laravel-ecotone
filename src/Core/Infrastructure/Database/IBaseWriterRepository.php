<?php
namespace Module\Core\Infrastructure\Database;

use Module\Core\Domain\Entity;
use Module\Core\Infrastructure\Database\Contracts\RepositoryError;

interface IBaseWriterRepository
{
    function upsert(Entity $data): RepositoryError|bool;
    function remove(array $filter): RepositoryError|bool;
}
