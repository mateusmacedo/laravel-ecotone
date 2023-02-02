<?php
namespace Module\Core\Application\Errors;

use Module\Core\Result;

class DataNotFoundError extends Result
{
    function __construct(string|array $error)
    {
        parent::__construct(false, null, $error);
    }
}
