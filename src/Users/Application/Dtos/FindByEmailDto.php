<?php

declare(strict_types=1);

namespace Module\Users\Application\Dtos;

use Module\Users\Domain\Email;

class FindByEmailDto
{
	public function __construct(private Email $email)
	{
	}

	public function getEmail(): Email
	{
		return $this->email;
	}
}