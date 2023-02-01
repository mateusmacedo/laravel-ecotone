<?php

declare(strict_types=1);

namespace Module\Users\Application\Commands;

use Ecotone\Messaging\MessagePublisher;
use Module\Core\Domain\Exception\ValidationExceptions;
use Module\Users\Application\Dtos\FindByEmailDto;
use Module\Users\Domain\Repositories\FindByEmailRepository;
use Module\Users\Domain\Repositories\UpsertRepository;
use Module\Users\Domain\UserAggregate;
use Module\Users\Application\Commands\ChangePasswordCommand;

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
