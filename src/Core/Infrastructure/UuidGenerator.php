<?php

declare(strict_types=1);

namespace Module\Core\Infrastructure;

use Module\Core\Domain\Contracts\IdGenerator;

class UuidGenerator implements IdGenerator
{
	public static function generate(): string
	{
		return \Ramsey\Uuid\Uuid::uuid4()->toString();
	}
}