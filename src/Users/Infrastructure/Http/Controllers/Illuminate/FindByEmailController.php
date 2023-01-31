<?php

declare(strict_types=1);

namespace Module\Users\Infrastructure\Http\Controllers\Illuminate;

use Ecotone\Modelling\QueryBus;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Module\Users\Application\Factories\UserCommandQueryFactory;
use Module\Users\Application\Factories\UserDtoFactory;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;

class FindByEmailController extends Controller
{
    public function __construct(
        private UserDtoFactory $dtoFactory,
        private UserCommandQueryFactory $commandQueryFactory,
        private QueryBus $queryBus
    ) {
    }

    public function get(Request $request)
    {
        $dto = $this->dtoFactory->findByEmailDto($request->all());
        $query = $this->commandQueryFactory->findByEmailQuery($dto);
        try {
            $user = $this->queryBus->send($query);
            if ($user) {
                return new JsonResponse($user, Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            $errorMessages = ['message' => $e->extractErrorMessages()];
            return new JsonResponse($errorMessages, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        return new Response(null, Response::HTTP_NOT_FOUND);
    }
}
