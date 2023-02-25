<?php
namespace Module\Core\Application\Errors;

use ArrayObject;
use Module\Core\Result;

class DataNotFoundError extends Result
{
    function __construct(private readonly ArrayObject $errors)
    {
        parent::__construct(false, null, $errors);
    }
}
