<?php
namespace Module\Core\Infrastructure\Database;

use Jenssegers\Mongodb\Eloquent\Model;
use Module\Core\Domain\Entity;
use Module\Core\Infrastructure\Database\Contracts\ListProps;
use Module\Core\Infrastructure\Database\Contracts\ListResponse;
use Module\Core\Infrastructure\Database\Contracts\RepositoryError;
use Module\Core\Mapper\IMapper;
use MongoException;

class MongoBaseRepository implements IBaseRepository
{
    function __construct(private Model $model, private IMapper $mapper)
    {
    }

    /**
     * @param ListProps $props
     * @return ListResponse
     */
    public function list(ListProps $props): ListResponse|RepositoryError
    {
        try {
            //throw new \ErrorException('huehuebrbr');
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

        } catch (\ErrorException | \BadMethodCallException | \TypeError $e) {
            return new RepositoryError($e);
        }

    }

    /**
     *
     * @param $data
     * @return mixed
     */
    public function upsert(Entity $domainData): RepositoryError|bool
    {
        try {
            $data = $this->mapper->toPersistence($domainData);
            $userModel = new $this->model($data);
            $result = $userModel->save();
            return $result;
        } catch (MongoException $e) {
            return new RepositoryError();
        }
    }

    /**
     *
     * @param array $filter
     * @return mixed
     */
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
            return $dataDb != null ? $this->mapper->toDomain($dataDb->toArray()) : null;
        } catch (MongoException $e) {
            return new RepositoryError();
        }
    }

    /**
     *
     * @param array $filter
     * @return mixed
     */
    public function remove(array $filter): bool|RepositoryError
    {
        try {
            $baseQuery = new $this->model();

            if (!empty($filter)) {
                foreach ($filter as $key => $value) {
                    $baseQuery = $baseQuery->where($key, $value);
                }
            }

            $result = $baseQuery->delete();

            return $result;
        } catch (MongoException $e) {
            return new RepositoryError();
        }
    }

    public function getPaginationParams(?int $page, ?int $perPage)
    {
        $perPage = $perPage ?? 10;
        $pageNumber = $page ? $page - 1 : 0;
        $skip = $perPage * $pageNumber;
        return ["take" => $perPage, "skip" => $skip];
    }
}
