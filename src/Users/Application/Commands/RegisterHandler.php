<?php

declare(strict_types=1);

namespace Module\Users\Application\Commands;

use Module\Core\Application\Errors\ApplicationError;
use Module\Core\Domain\Exception\DomainError;
use Module\Core\Infrastructure\Database\Contracts\RepositoryError;
use Module\Core\Result;
use Module\Users\Domain\Contracts\IUserRepository;
use Module\Users\Domain\Email;
use Module\Users\Domain\Password;
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
        $errors = Result::combine([$emailOrError, $passwordOrError]);
        if ($errors->isError) {
            return $errors;
        }
        $result = UserAggregate::register(null, $emailOrError, $passwordOrError);
        if ($result instanceof DomainError) {
            return new ApplicationError('erro ao criar usuário');
        }
        $resUpsert = $this->repository->upsert($result);
        if ($resUpsert instanceof RepositoryError) {
            return new ApplicationError('erro ao salvar');
        }
        return Result::ok($result);
    }
}
