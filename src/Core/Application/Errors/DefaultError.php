<?php
namespace Module\Core\Application\Errors;

use Module\Core\Result;

class DefaultError extends Result
{
    function __construct(mixed $error)
    {
        parent::__construct(false, null, $error);
    }
}
