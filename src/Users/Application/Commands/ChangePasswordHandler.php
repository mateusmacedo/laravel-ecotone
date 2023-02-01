<?php

declare(strict_types=1);

namespace Module\Users\Application\Commands;

use Module\Core\Domain\Exception\ValidationExceptions;
use Module\Users\Application\Commands\ChangePasswordCommand;
use Module\Users\Domain\Repositories\FindByEmailRepository;
use Module\Users\Domain\Repositories\UpsertRepository;

class ChangePasswordHandler
{
    public function __construct(private UpsertRepository $repository, private FindByEmailRepository $findRepository)
    {
    }

    public function handle(ChangePasswordCommand $command): void
    {
        $dto = $command->getDto();
        $newPassword = $dto->getNewPassword();
        $email = $dto->getEmail();
        $user = $this->findRepository->findByEmail($email);
        if (!$user) {
            return;
        }
        $user->changePassword($newPassword);
        $user->validate();
        if ($user->hasAnyException()) {
            throw new ValidationExceptions($user->getExceptions());
        }
        $this->repository->upsert($user);
    }
}
