<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Infrastructure\Database\Cache;

use Module\Core\Infrastructure\Cache\ICacheStore;
use Module\Core\Infrastructure\Database\Cache\CacheableRepository;
use Module\Core\Infrastructure\Database\Contracts\IBaseReaderRepository;
use Module\Core\Infrastructure\Database\Contracts\IBaseWriterRepository;
use Module\Core\Infrastructure\Database\Contracts\ListProps;
use Module\Core\Infrastructure\Database\Contracts\ListResponse;
use Module\Core\Infrastructure\Database\Errors\RepositoryError;
use PHPUnit\Framework\TestCase;

class CacheableRepositoryTest extends TestCase
{
    private $cacheStore;
    private $readerRepository;
    private $writerRepository;
    private $repository;

    protected function setUp(): void
    {
        $this->cacheStore = $this->createMock(ICacheStore::class);
        $this->readerRepository = $this->createMock(IBaseReaderRepository::class);
        $this->writerRepository = $this->createMock(IBaseWriterRepository::class);
        $this->repository = new CacheableRepository(
            $this->cacheStore,
            $this->readerRepository,
            $this->writerRepository
        );
    }

    public function testListShouldReturnCachedDataWhenAvailable(): void
    {
        $props = ListProps::create();
        $cachedData = ListResponse::create([], 10, 100);
        $cacheKey = $this->generateCacheKey($this->repository::class, 'list', $props);

        $this->cacheStore
            ->expects($this->once())
            ->method('get')
            ->with($cacheKey)
            ->willReturn($cachedData);

        $this->readerRepository
            ->expects($this->never())
            ->method('list');

        $this->cacheStore
            ->expects($this->never())
            ->method('put');

        $result = $this->repository->list($props);

        $this->assertSame($cachedData, $result);
    }

    public function testListShouldReturnFreshDataWhenNotCached(): void
    {
        $props = ListProps::create();
        $freshData = ListResponse::create([], 10, 100);
        $cacheKey = $this->generateCacheKey($this->repository::class, 'list', $props);

        $this->cacheStore
            ->expects($this->once())
            ->method('get')
            ->with($cacheKey)
            ->willReturn(null);

        $this->readerRepository
            ->expects($this->once())
            ->method('list')
            ->with($props)
            ->willReturn($freshData);

        $this->cacheStore
            ->expects($this->once())
            ->method('put')
            ->with($cacheKey, $freshData, 60);

        $result = $this->repository->list($props);

        $this->assertSame($freshData, $result);
    }

    public function testListShouldReturnRepositoryErrorWhenReaderRepositoryReturnsRepositoryError(): void
    {
        $props = ListProps::create();
        $error = new RepositoryError('An error occurred while reading from the database.');
        $cacheKey = $this->generateCacheKey($this->repository::class, 'list', $props);

        $this->cacheStore
            ->expects($this->once())
            ->method('get')
            ->willReturn(null);

        $this->readerRepository
            ->expects($this->once())
            ->method('list')
            ->willReturn($error);

        $this->cacheStore
            ->expects($this->never())
            ->method('put');

        $result = $this->repository->list($props);

        $this->assertSame($error, $result);
    }

    public function testFindOneReturnsCachedData()
    {
        $filter = ['id' => 'dummy-id'];
        $cachedData = new EntityStub('dummy-id', 'dummy-name');
        $cacheKey = $this->generateCacheKey($this->repository::class, 'findOne', $filter);

        $this->cacheStore
            ->expects($this->once())
            ->method('get')
            ->with($cacheKey)
            ->willReturn($cachedData);

        $this->readerRepository
            ->expects($this->never())
            ->method('findOne');

        $result = $this->repository->findOne($filter);
        $this->assertEquals($cachedData, $result);
    }

    public function testFindOneSavesDataToCache()
    {
        $filter = ['id' => 'dummy-id'];
        $entity = new EntityStub('dummy-id', 'dummy-name');
        $cacheKey = $this->generateCacheKey($this->repository::class, 'findOne', $filter);

        $this->cacheStore
            ->expects($this->once())
            ->method('get')
            ->willReturn(null);

        $this->readerRepository
            ->expects($this->once())
            ->method('findOne')
            ->with($this->equalTo($filter))
            ->willReturn($entity);

        $this->cacheStore
            ->expects($this->once())
            ->method('put')
            ->with($cacheKey);

        $result = $this->repository->findOne($filter);
        $this->assertEquals($entity, $result);
    }

    public function testFindOneReturnsRepositoryError()
    {
        $filter = ['id' => 1];
        $repositoryError = new RepositoryError('Something went wrong');

        $this->cacheStore
            ->expects($this->once())
            ->method('get')
            ->willReturn(null);

        $this->readerRepository
            ->expects($this->once())
            ->method('findOne')
            ->with($this->equalTo($filter))
            ->willReturn($repositoryError);

        $this->cacheStore
            ->expects($this->never())
            ->method('put');

        $result = $this->repository->findOne($filter);
        $this->assertEquals($repositoryError, $result);
    }

    public function testUpsertReturnsErrorOnWriterError()
    {
        $entity = new EntityStub('dummy-id', 'dummy-name');
        $repositoryError = new RepositoryError(new \Exception('Something went wrong'));

        $this->writerRepository
            ->expects($this->once())
            ->method('upsert')
            ->with($this->equalTo($entity))
            ->willReturn($repositoryError);

        $result = $this->repository->upsert($entity);
        $this->assertSame($repositoryError, $result);
    }

    public function testUpsertFlushesCacheOnSuccess()
    {
        $entity = new EntityStub('dummy-id', 'dummy-name');

        $this->writerRepository
            ->expects($this->once())
            ->method('upsert')
            ->with($this->equalTo($entity))
            ->willReturn(true);

        $this->cacheStore
            ->expects($this->once())
            ->method('flush');

        $result = $this->repository->upsert($entity);
        $this->assertTrue($result);
    }

    public function testRemoveShouldReturnTrueOnSuccessfulDeletion(): void
    {
        $filter = ['id' => 1];
        $cacheKey = $this->generateCacheKey($this->repository::class, 'remove', $filter);
        $this->writerRepository->expects($this->once())
            ->method('remove')
            ->with($filter)
            ->willReturn(true);

        $result = $this->repository->remove($filter);

        $this->assertTrue($result);
        $this->assertNull($this->cacheStore->get($cacheKey));
    }

    public function testRemoveShouldReturnRepositoryErrorOnUnsuccessfulDeletion(): void
    {
        $filter = ['id' => 1];
        $cacheKey = $this->generateCacheKey($this->repository::class, 'remove', $filter);
        $repositoryError = new RepositoryError('Error deleting entity');
        $this->writerRepository->expects($this->once())
            ->method('remove')
            ->with($filter)
            ->willReturn($repositoryError);

        $result = $this->repository->remove($filter);

        $this->assertInstanceOf(RepositoryError::class, $result);
        $this->assertNull($this->cacheStore->get($cacheKey));
    }

    public function testRemoveShouldFlushCacheStoreOnSuccessfulDeletion(): void
    {
        $filter = ['id' => 1];
        $this->writerRepository->expects($this->once())
            ->method('remove')
            ->with($filter)
            ->willReturn(true);
        $this->cacheStore->expects($this->once())
            ->method('flush');

        $this->repository->remove($filter);
    }

    public function testRemoveShouldFlushCacheStoreOnUnsuccessfulDeletion(): void
    {
        $filter = ['id' => 1];
        $repositoryError = new RepositoryError('Error deleting entity');
        $this->writerRepository->expects($this->once())
            ->method('remove')
            ->with($filter)
            ->willReturn($repositoryError);
        $this->cacheStore->expects($this->never())
            ->method('flush');

        $this->repository->remove($filter);
    }

    protected function generateCacheKey(string $className, string $methodName, mixed $props): string
    {
        return md5($className . '::' . $methodName . serialize($props));
    }
}
