<?php

declare(strict_types=1);

namespace Module\Core\Infrastructure\Ecotone\Contracts;

interface ISerializeToQueue
{
    public function toArray(): array;
}
