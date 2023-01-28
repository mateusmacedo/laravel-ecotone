<?php

declare(strict_types=1);

namespace Module\Core\Infrastructure;

use Module\Core\Domain\Contracts\IdGenerator;
use Ramsey\Uuid\Uuid;

class UuidGenerator implements IdGenerator
{
    public static function generate(): string
    {
        return Uuid::uuid4()->toString();
    }
}
