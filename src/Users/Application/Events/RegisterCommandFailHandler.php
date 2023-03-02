<?php

declare(strict_types=1);

namespace Module\Users\Application\Events;

use Illuminate\Support\Facades\Log;

class RegisterCommandFailHandler
{
    public function handle(RegisterCommandFailEvent $event): void
    {
        Log::info('RegisterCommandFailEvent: error:{error} data:{data}', [
            'error' => $event->getError(),
            'data' => json_encode($event->getCommand()->toArray())
        ]);
    }
}
