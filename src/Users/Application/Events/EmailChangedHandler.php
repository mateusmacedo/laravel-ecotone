<?php

declare(strict_types=1);

namespace Module\Users\Application\Events;

use Illuminate\Support\Facades\Log;
use Module\Users\Domain\Repositories\FindByIdRepository;

class EmailChangedHandler
{
    public function __construct(private FindByIdRepository $repository)
    {
    }

    public function handle(EmailChangedEvent $event)
    {
        $user = $this->repository->findById($event->getUserAggregate()->getId());
        Log::info("Sending email to user {$user->getEmail()->getValue()}");
    }
}
