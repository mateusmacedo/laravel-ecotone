<?php

declare(strict_types=1);

namespace Module\Users\Infrastructure\Http\Controllers\Illuminate;

use Ecotone\Modelling\CommandBus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Module\Core\Application\Errors\ApplicationError;
use Module\Core\Application\Errors\DataNotFoundError;
use Module\Users\Application\Factories\UserCommandQueryFactory;
use Module\Users\Application\Factories\UserDtoFactory;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    public function __construct(
        private UserDtoFactory $dtoFactory,
        private UserCommandQueryFactory $commandQueryFactory,
        private CommandBus $commandBus
    )
    {
    }

    public function post(Request $request): JsonResponse
    {
        $command = $this->commandQueryFactory->registerCommand($request->all());
        $res = $this->commandBus->send($command);
        if ($res->isError) {
            switch (true) {
                case $res instanceof ApplicationError:
                    return new JsonResponse($res->getError(), Response::HTTP_INTERNAL_SERVER_ERROR);
                default:
                    return new JsonResponse('erro ao processar a requisição.', Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }

        return new Response(null, Response::HTTP_CREATED);
    }
}
