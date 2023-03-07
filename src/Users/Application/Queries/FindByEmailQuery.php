<?php

declare(strict_types=1);

namespace Module\Users\Application\Queries;

class FindByEmailQuery
{
    public function __construct(public readonly string $email)
    {
    }
}
