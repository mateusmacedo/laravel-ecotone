<?php

declare(strict_types=1);

namespace Module\Users\Application\Commands;

use Module\Core\Application\Errors\ApplicationError;
use Module\Core\Infrastructure\Database\Contracts\RepositoryError;
use Module\Core\Result;
use Module\Users\Domain\Email;
use Module\Users\Domain\Password;
use Module\Users\Domain\Repository\IUserRepository;
use Module\Users\Domain\UserAggregate;

class RegisterHandler
{
    public function __construct(private IUserRepository $repository)
    {
    }

    public function handle(RegisterCommand $command): Result
    {
        $emailOrError = Email::create($command->email);
        $passwordOrError = Password::create($command->password);
        $errorsCombined = Result::combine([$emailOrError, $passwordOrError]);
        if ($errorsCombined->isError) {
            return new ApplicationError($errorsCombined->getError());
        }
        $user = UserAggregate::register(null, $emailOrError, $passwordOrError);
        $resUpsert = $this->repository->upsert($user);
        if ($resUpsert instanceof RepositoryError) {
            return new ApplicationError('erro ao salvar');
        }
        return Result::ok($user);
    }
}
