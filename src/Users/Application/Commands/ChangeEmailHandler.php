<?php

declare(strict_types=1);

namespace Module\Users\Application\Commands;

use Module\Core\Domain\Exception\ValidationException;
use Module\Core\Domain\Exception\ValidationExceptions;
use Module\Users\Domain\Repositories\FindByEmailRepository;
use Module\Users\Domain\Repositories\FindByIdRepository;
use Module\Users\Domain\Repositories\UpsertRepository;
use Module\Users\Domain\UserAggregate;

class ChangeEmailHandler
{
    public function __construct(
        private FindByIdRepository $findByIdRepository,
        private FindByEmailRepository $findByEmailRepository,
        private UpsertRepository $upsertRepository
    ) {
    }

    public function handle(ChangeEmailCommand $command): ?UserAggregate
    {
        $dto = $command->getDto();
        $email = $dto->getEmail();
        $isEmailAlreadyInUse = $this->findByEmailRepository->findByEmail($email);
        if ($isEmailAlreadyInUse) {
            throw new ValidationExceptions([
                new ValidationException('Email already in use', $email->getIdentifier())
            ]);
        }
        $user = $this->findByIdRepository->findById($dto->getUserId());
        $user->changeEmail($email);
        $user->validate();
        if ($user->hasAnyException()) {
            throw new ValidationExceptions($user->getExceptions());
        }
        $this->upsertRepository->upsert($user);
        return $user;
    }
}
