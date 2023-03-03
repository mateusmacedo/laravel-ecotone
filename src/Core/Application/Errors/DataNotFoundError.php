<?php

declare(strict_types=1);

namespace Module\Core\Application\Errors;

use Module\Core\Result;

class DataNotFoundError extends Result
{
    public function __construct(private readonly mixed $errors)
    {
        parent::__construct(false, null, $errors);
    }
}
