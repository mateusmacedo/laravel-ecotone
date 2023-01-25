<?php

declare(strict_types=1);

namespace Module\Users\Application\Queries;

use Module\Users\Application\Dtos\FindByEmailDto;

class FindByEmailQuery
{
	public function __construct(private FindByEmailDto $dto) {}

	public function getDto(): FindByEmailDto
	{
		return $this->dto;
	}
}