<?php

declare(strict_types=1);

namespace Module\Users\Application\Events;

use Illuminate\Support\Facades\Log;
use Module\Users\Domain\Repository\IUserRepository;

class UserRegisteredHandler
{
    public function __construct(private IUserRepository $repository)
    {
    }

    public function handle(UserRegisteredEvent $event): void
    {
        $user = $this->repository->findOne(['id' => $event->id]);
        Log::info("Sending email to user {$user->getEmail()->value} confirming registration");
    }
}
