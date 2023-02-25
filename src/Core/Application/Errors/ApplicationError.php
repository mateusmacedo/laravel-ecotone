<?php
namespace Module\Core\Application\Errors;

use ArrayObject;
use Module\Core\Result;

class ApplicationError extends Result
{
    function __construct(private readonly ArrayObject|string $errors)
    {
        parent::__construct(false, null, $errors);
    }
}
