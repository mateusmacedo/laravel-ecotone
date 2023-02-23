<?php

declare(strict_types=1);

namespace Module\Users\Application\Commands;

use Module\Core\Domain\Exception\ValidationException;
use Module\Core\Domain\Exception\ValidationExceptions;
use Module\Users\Domain\Repositories\FindByIdRepository;
use Module\Users\Domain\Repositories\UpsertRepository;

class ChangePasswordHandler
{
    public function __construct(private UpsertRepository $repository, private FindByIdRepository $findRepository)
    {
    }

    public function handle(ChangePasswordCommand $command): void
    {
        $dto = $command->getDto();
        $user = $this->findRepository->findById($dto->getUserId());
        if (!$user) {
            throw new ValidationExceptions([
                new ValidationException('User not found', 'userId')
            ]);
        }
        $user->changePassword($dto->getPassword());
        $user->validate();
        if ($user->hasAnyException()) {
            throw new ValidationExceptions($user->getExceptions());
        }
        $this->repository->upsert($user);
    }
}
