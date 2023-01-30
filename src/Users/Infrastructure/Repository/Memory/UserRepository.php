<?php

declare(strict_types=1);

namespace Module\Users\Infrastructure\Repository\Memory;

use Module\Users\Domain\Email;
use Module\Users\Domain\Repositories\FindByEmailRepository;
use Module\Users\Domain\Repositories\FindByIdRepository;
use Module\Users\Domain\Repositories\UpsertRepository;
use Module\Users\Domain\UserAggregate;

class UserRepository implements UpsertRepository, FindByEmailRepository, FindByIdRepository
{
    private $users = [];

    public function upsert(UserAggregate $user): void
    {
        $this->users[$user->getId()] = $user;
    }

    public function findByEmail(Email $email): ?UserAggregate
    {
        foreach ($this->users as $user) {
            if ($user->getEmail()->equals($email)) {
                return $user;
            }
        }
        return null;
    }

    public function findById(string $id): ?UserAggregate
    {
        return $this->users[$id] ?? null;
    }
}
