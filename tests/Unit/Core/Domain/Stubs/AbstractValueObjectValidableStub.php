<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Domain\Stubs;

use Module\Core\Domain\AbstractValueObjectValidable;
use Module\Core\Domain\Contracts\ValueObject;

class AbstractValueObjectValidableStub extends AbstractValueObjectValidable
{
	protected string $identifier = self::class;

	public function __construct(mixed $value)
	{
		parent::__construct($value);
	}

	public function equals(ValueObject $valueObject): bool
	{
		return true;
	}

	public function validate(): void
	{
	}
}