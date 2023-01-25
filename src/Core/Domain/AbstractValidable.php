<?php

declare(strict_types=1);

namespace Module\Core\Domain;

use Module\Core\Domain\Contracts\Validable;
use Module\Core\Domain\Exception\ValidationException;

abstract class AbstractValidable implements Validable
{
	protected array $exceptions = [];

	public function addException(ValidationException $e) {
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