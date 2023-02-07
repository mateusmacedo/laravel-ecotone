<?php
namespace Module\Core\Infrastructure\Database;

use Module\Core\Domain\Entity;
use Module\Core\Infrastructure\Database\Contracts\ListProps;
use Module\Core\Infrastructure\Database\Contracts\ListResponse;
use Module\Core\Infrastructure\Database\Contracts\RepositoryError;

interface IBaseReaderRepository
{
    function list(ListProps $props): ListResponse|RepositoryError;
    function findOne(array $filter): Entity|RepositoryError|null;
}
