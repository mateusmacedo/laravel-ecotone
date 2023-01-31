<?php

declare(strict_types=1);

namespace Module\Core\Domain\Exception;

use DomainException;

class ValidationException extends DomainException
{
    public function __construct(
        string $message,
        private string $identifier,
    )
    {
        parent::__construct($message);
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }
}