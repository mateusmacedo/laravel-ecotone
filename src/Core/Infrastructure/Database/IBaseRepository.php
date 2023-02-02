<?php
namespace Module\Core\Infrastructure\Database;

use Module\Core\Domain\Entity;
use Module\Core\Infrastructure\Database\contracts\ListProps;
use Module\Core\Infrastructure\Database\contracts\ListResponse;
use Module\Core\Infrastructure\Database\Contracts\RepositoryError;

interface IBaseRepository
{
    function list(ListProps $props): ListResponse|RepositoryError;
    function upsert(Entity $data): RepositoryError|bool;
    function findOne(array $filter): Entity|RepositoryError|null;
    function remove(array $filter);
}
