<?php

declare(strict_types=1);

namespace Module\Users\Application\Events;

use Module\Core\Infrastructure\Ecotone\Contracts\ISerializeToQueue;
use Module\Users\Domain\UserAggregate;

class UserRegisteredEvent implements ISerializeToQueue
{
    public function __construct(private UserAggregate $userAggregate)
    {
    }

    public function getUserAggregate(): UserAggregate
    {
        return $this->userAggregate;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'userAggregate' => $this->userAggregate->toArray(),
        ];
    }
}
