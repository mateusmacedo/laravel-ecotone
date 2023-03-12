<?php

declare(strict_types=1);

namespace Module\Core\Infrastructure\Database\Cache;

use Module\Core\Domain\Entity;
use Module\Core\Infrastructure\Cache\ICacheStore;
use Module\Core\Infrastructure\Database\Contracts\IBaseReaderRepository;
use Module\Core\Infrastructure\Database\Contracts\IBaseWriterRepository;
use Module\Core\Infrastructure\Database\Contracts\ListProps;
use Module\Core\Infrastructure\Database\Contracts\ListResponse;
use Module\Core\Infrastructure\Database\Errors\RepositoryError;

class CacheableRepository implements IBaseReaderRepository, IBaseWriterRepository
{
    public function __construct(private ICacheStore $cacheStore, private IBaseReaderRepository $readerRepository, private IBaseWriterRepository $writerRepository)
    {
    }

    public function list(ListProps $props): ListResponse|RepositoryError
    {
        $cacheKey = $this->generateCacheKey(__METHOD__, $props);
        $cachedData = $this->cacheStore->get($cacheKey);
        if (null !== $cachedData) {
            return $cachedData;
        }

        $result = $this->readerRepository->list($props);
        if ($result instanceof ListResponse) {
            // TODO: Add a TTL to the cache from config
            $this->cacheStore->put($cacheKey, $result, 60);
        }

        return $result;
    }

    public function findOne(array $filter): Entity|RepositoryError|null
    {
        $cacheKey = $this->generateCacheKey(__METHOD__, $filter);
        $cachedData = $this->cacheStore->get($cacheKey);
        if (null !== $cachedData) {
            return $cachedData;
        }

        $result = $this->readerRepository->findOne($filter);
        if ($result instanceof Entity) {
            // TODO: Add a TTL to the cache from config
            $this->cacheStore->put($cacheKey, $result, 60);
        }

        return $result;
    }

    public function upsert(Entity $domainData): RepositoryError|bool
    {
        $result = $this->writerRepository->upsert($domainData);
        if ($result instanceof RepositoryError) {
            return $result;
        }

        $this->cacheStore->flush();
        return $result;
    }

    public function remove(array $filter): bool|RepositoryError
    {
        $result = $this->writerRepository->remove($filter);
        if ($result instanceof RepositoryError) {
            return $result;
        }

        $this->cacheStore->flush();
        return $result;
    }

    private function generateCacheKey(string $methodName, $params): string
    {
        return md5($methodName . serialize($params));
    }
}
