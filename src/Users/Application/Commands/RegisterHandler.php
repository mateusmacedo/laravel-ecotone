<?php

declare(strict_types=1);

namespace Module\Users\Application\Commands;

use Module\Core\Application\Errors\ApplicationError;
use Module\Core\Application\Errors\DataNotFoundError;
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
        if ($emailOrError instanceof DomainError)
            return new ApplicationError($emailOrError->getErrors());

        $passwordOrError = Password::create($command->password);
        if ($passwordOrError instanceof DomainError)
            return new DataNotFoundError($passwordOrError->getErrors());

        $user = UserAggregate::register(null, $emailOrError, $passwordOrError);
        $resUpsert = $this->repository->upsert($user);
        if ($resUpsert instanceof RepositoryError)
            return new ApplicationError('erro ao salvar');

        /*         $dto = $command->getDto();
        dd($dto->getEmail(), $dto->getPassword());
        $user = UserAggregate::register(null, $dto->getEmail(), $dto->getPassword());
        dd($user);
        $this->repository->upsert($user); */
        //$messagePublisher->send($user->toJson(), 'application/json');
        return Result::ok($user);
    }
}
