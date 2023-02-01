<?php

declare(strict_types=1);

namespace Module\Users\Application\Commands;

use Module\Users\Domain\Repositories\FindByEmailRepository;
use Module\Users\Domain\Repositories\UpsertRepository;

class ChangeEmailHandler
{
    public function __construct(
        private FindByEmailRepository $findByEmailRepository,
        private UpsertRepository $upsertRepository
    ) {
    }

    public function handle(ChangeEmailCommand $command): void
    {
        $dto = $command->getDto();
        $newEmail = $dto->getNewEmail();
        $isEmailAlreadyInUse = $this->findByEmailRepository->findByEmail($newEmail);
        if ($isEmailAlreadyInUse) {
            return;
        }
        $user = $this->findByEmailRepository->findByEmail($dto->getCurrentEmail());
        $user->changeEmail($newEmail);
        $this->upsertRepository->upsert($user);
    }
}
