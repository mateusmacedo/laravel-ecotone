<?php

declare(strict_types=1);

namespace Module\Core\Infrastructure\Cache;

interface ICacheStore
{
    public function has(string $key): bool;

    public function get(string $key);

    public function put(string $key, mixed $value, int $minutes): bool;

    public function pull(string $key);

    public function forget(string $key): bool;

    public function flush(): bool;
}
