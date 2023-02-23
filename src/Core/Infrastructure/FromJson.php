<?php

declare(strict_types=1);

namespace Module\Core\Infrastructure;

interface FromJson
{
    public static function fromJson(string $json): self;
}
