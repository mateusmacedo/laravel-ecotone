<?php

declare(strict_types=1);

namespace Module\Users\Application\Events;

use Module\Core\Infrastructure\FromArray;
use Module\Users\Domain\UserAggregate;

class UserRegisteredEvent implements \JsonSerializable, FromArray
{
    public function __construct(private UserAggregate $userAggregate)
    {
    }

    public function getUserAggregate(): UserAggregate
    {
        return $this->userAggregate;
    }

    public static function fromArray($data): self
    {
        return new self(UserAggregate::fromArray($data));
    }

    public function jsonSerialize(): array
    {
        return $this->getUserAggregate()->arraySerialize();
    }
}
