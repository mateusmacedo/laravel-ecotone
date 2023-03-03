<?php

declare(strict_types=1);

namespace Module\Core\Infrastructure\Database\MongoDB;

use Jenssegers\Mongodb\Eloquent\Model;
use Module\Core\Domain\Entity;
use Module\Core\Infrastructure\Database\Contracts\IBaseReaderRepository;
use Module\Core\Infrastructure\Database\Contracts\IBaseWriterRepository;
use Module\Core\Infrastructure\Database\Contracts\ListProps;
use Module\Core\Infrastructure\Database\Contracts\ListResponse;
use Module\Core\Infrastructure\Database\Errors\RepositoryError;
use Module\Core\Mapper\IMapper;

class MongoBaseRepository implements IBaseReaderRepository, IBaseWriterRepository
{
    public function __construct(private Model $model, private IMapper $mapper)
    {
    }

    public function list(ListProps $props): ListResponse|RepositoryError
    {
        try {
            $paginateParams = $this->getPaginationParams($props->page, $props->perPage);
            $baseQuery = new $this->model();
            if (!empty($props->filters)) {
                foreach ($props->filters as $key => $value) {
                    $baseQuery = $baseQuery->where($key, $value);
                }
            }
            $count = $baseQuery->get()->count();
            $dataDb = $baseQuery->get()
                ->skip($paginateParams['skip'])
                ->take($paginateParams['take'])
                ->toArray();
            $domainData = new \ArrayObject(
                array_map(function ($item) {
                    return $this->mapper->toDomain($item);
                }, $dataDb)
            );
            return ListResponse::create($domainData, $paginateParams['take'], $count);
        } catch (\ErrorException|\BadMethodCallException|\TypeError $e) {
            return new RepositoryError($e);
        }
    }

    public function upsert(Entity $domainData): RepositoryError|bool
    {
        try {
            $data = $this->mapper->toPersistence($domainData);
            $userModel = new $this->model($data);
            return $userModel->save();
        } catch (\ErrorException|\BadMethodCallException|\TypeError $e) {
            return new RepositoryError($e);
        }
    }

    public function findOne(array $filter): Entity|RepositoryError|null
    {
        try {
            $baseQuery = new $this->model();
            if (!empty($filter)) {
                foreach ($filter as $key => $value) {
                    $baseQuery = $baseQuery->where($key, $value);
                }
            }
            $dataDb = $baseQuery->first();
            return null != $dataDb ? $this->mapper->toDomain($dataDb->toArray()) : null;
        } catch (\ErrorException|\BadMethodCallException|\TypeError $e) {
            return new RepositoryError($e);
        }
    }

    public function remove(array $filter): bool|RepositoryError
    {
        try {
            $baseQuery = new $this->model();
            if (!empty($filter)) {
                foreach ($filter as $key => $value) {
                    $baseQuery = $baseQuery->where($key, $value);
                }
            }
            return $baseQuery->delete();
        } catch (\ErrorException|\BadMethodCallException|\TypeError $e) {
            return new RepositoryError($e);
        }
    }

    public function getPaginationParams(?int $page, ?int $perPage)
    {
        $perPage = $perPage ?? 10;
        $pageNumber = $page ? $page - 1 : 0;
        $skip = $perPage * $pageNumber;
        return ['take' => $perPage, 'skip' => $skip];
    }
}
