<?php
declare(strict_types=1);

namespace Module\Core\Domain\Exception;

use ArrayObject;

class DomainError
{
    function __construct(private readonly ArrayObject $errors, private readonly ?string $domainName = null)
    {
    }

    function getErrors(): ArrayObject
    {
        if ($this->domainName)
            return new ArrayObject([$this->domainName => (array) $this->errors]);

        return $this->errors;
    }
}
