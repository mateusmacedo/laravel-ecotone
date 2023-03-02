<?php

declare(strict_types=1);

namespace Module\Core\Application\Errors;

use Module\Core\Result;

class ApplicationError extends Result
{
    public function __construct(private readonly \ArrayObject|string $errors)
    {
        parent::__construct(false, null, $errors);
    }
}
