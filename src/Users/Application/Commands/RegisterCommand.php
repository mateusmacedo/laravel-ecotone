<?php

declare(strict_types=1);

namespace Module\Users\Application\Commands;

use Module\Users\Application\Dtos\RegisterDto;

class RegisterCommand
{
	public function __construct(private RegisterDto $registerDto)
	{
	}

	public function getDto(): RegisterDto
	{
		return $this->registerDto;
	}
}