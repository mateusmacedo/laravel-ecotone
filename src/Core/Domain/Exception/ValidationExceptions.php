<?php

declare(strict_types=1);

namespace Module\Core\Domain\Exception;

use DomainException;

class ValidationExceptions extends DomainException
{
    private $items = [];

    public function __construct(array $exceptions = [])
    {
        foreach ($exceptions as $e) {
            if ($e instanceof ValidationException) {
                $this->add($e);
            }
        }
    }

    public function add(ValidationException $exception)
    {
        $this->items[] = $exception;
    }

    public function getAll(): array
    {
        return $this->items;
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function getCurrent(): ?ValidationException
    {
        return current($this->items);
    }

    public function extractErrorMessages(): array
    {
        $errorMessages = [];

        foreach ($this->getAll() as $e) {
            $errorMessages[$e->getIdentifier()][] = $e->getMessage();
        }

        return $errorMessages;
    }
}
