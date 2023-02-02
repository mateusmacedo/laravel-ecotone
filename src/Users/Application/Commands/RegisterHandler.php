<?php

declare(strict_types=1);

namespace Module\Users\Application\Commands;

use Ecotone\Messaging\MessagePublisher;
use Module\Core\Application\Errors\DefaultError;
use Module\Core\Domain\Exception\ValidationExceptions;
use Module\Users\Domain\Repositories\UpsertRepository;
use Module\Users\Domain\UserAggregate;

class RegisterHandler
{
    public function __construct(private IUserRepository $repository)
    {
    }


    public function handle(RegisterCommand $command): DefaultError|Result
    {
        $dto = $command->getDto();
        $user = UserAggregate::register(null, $dto->getEmail(), $dto->getPassword());
        //$user->validate();
        if ($user->hasAnyException()) {
            throw new ValidationExceptions($user->getExceptions());
        }
        $this->repository->upsert($user);
        //$messagePublisher->send($user->toJson(), 'application/json');
        return Result::ok($user);
    }
}
