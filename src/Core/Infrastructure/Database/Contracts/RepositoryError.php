<?php
namespace Module\Core\Infrastructure\Database\Contracts;

class RepositoryError
{
    function __construct(private readonly mixed $error)
    {
    }

    function getError()
    {
        return $this->error;
    }

}
