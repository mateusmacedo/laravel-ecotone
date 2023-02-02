<?php
declare(strict_types=1);

namespace Module\Core\Domain;
use Module\Core\Domain\Exception\ValidationException;
use Module\Core\Infrastructure\UuidGenerator;

abstract class Entity
{

    function __construct(public ?string $uuid = null)
    {
        $this->uuid = $uuid ?? UuidGenerator::generate();
    }

    protected array $exceptions = [];

    public function addException(ValidationException $e)
    {
        $this->exceptions[] = $e;
    }

    public function hasAnyException(): bool
    {
        return count($this->exceptions) > 0;
    }

    public function getExceptions(): array
    {
        return $this->exceptions;
    }
}
