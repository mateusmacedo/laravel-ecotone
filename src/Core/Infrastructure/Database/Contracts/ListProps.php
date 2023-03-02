<?php

declare(strict_types=1);

namespace Module\Core\Infrastructure\Database\Contracts;

class ListProps
{
    private function __construct(public readonly ?int $page = null, public readonly ?int $perPage = null, public readonly ?array $filters = [])
    {
    }

    public static function create(?int $page = null, ?int $perPage = null, ?array $filters = []): self
    {
        return new ListProps($page, $perPage, $filters);
    }
}
