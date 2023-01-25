<?php

declare(strict_types=1);

namespace Module\Core\Domain\Contracts;

interface ValueObject
{
	public function getIdentifier(): string;
	public function getValue(): mixed;
	public function equals(ValueObject $valueObject): bool;
}