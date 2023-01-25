<?php

declare(strict_types=1);

namespace Module\Users\Domain\Events;

class UserRegisteredEvent
{
	public function __construct(private string $userId)
	{
	}

	public function getUserId(): string
	{
		return $this->userId;
	}
}