<?php

declare(strict_types=1);

namespace Module\Users\Application\Events;

class UserRegisteredEvent
{
	public function __construct(private string $userId)
	{
	}

	public function getUserId(): string
	{
		return $this->userId;
	}

	public static function fromArray($data): self
	{
		return new self($data['userId']);
	}
}