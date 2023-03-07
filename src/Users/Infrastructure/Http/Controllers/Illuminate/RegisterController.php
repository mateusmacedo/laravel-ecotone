<?php

declare(strict_types=1);

namespace Module\Users\Infrastructure\Http\Controllers\Illuminate;

use Ecotone\Modelling\CommandBus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Module\Core\Application\Errors\ApplicationError;
use Module\Users\Application\Commands\RegisterCommand;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    public function __construct(
        private CommandBus $commandBus
    ) {
    }

    public function post(Request $request): JsonResponse
    {
        $command = new RegisterCommand(...$request->all());
        $res = $this->commandBus->send($command);
        if ($res->isError) {
            return match (true) {
                $res instanceof ApplicationError => new JsonResponse($res->getError(), Response::HTTP_INTERNAL_SERVER_ERROR),
                default => new JsonResponse('erro ao processar a requisição.', Response::HTTP_INTERNAL_SERVER_ERROR),
            };
        }

        return new JsonResponse(null, Response::HTTP_CREATED);
    }
}
