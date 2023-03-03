<?php

declare(strict_types=1);

namespace Module\Users\Infrastructure\Http\Controllers\Illuminate;

use Ecotone\Modelling\QueryBus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Module\Core\Domain\Errors\ValidationExceptions;
use Module\Users\Application\Factories\UserCommandQueryFactory;
use Module\Users\Application\Factories\UserDtoFactory;
use Symfony\Component\HttpFoundation\Response;

class FindByEmailController extends Controller
{
    public function __construct(
        private UserDtoFactory $dtoFactory,
        private UserCommandQueryFactory $commandQueryFactory,
        private QueryBus $queryBus
    ) {
    }

    public function get(Request $request): JsonResponse
    {
        $dto = $this->dtoFactory->findByEmailDto($request->route()->parameter('userEmail'));
        $query = $this->commandQueryFactory->findByEmailQuery($dto);
        $result = new JsonResponse(null, Response::HTTP_NOT_FOUND);
        try {
            $user = $this->queryBus->send($query);
            if ($user) {
                $result = new JsonResponse($user, Response::HTTP_OK);
            }
        } catch (ValidationExceptions $e) {
            $errorMessages = ['message' => $e->extractErrorMessages()];
            $result = new JsonResponse($errorMessages, Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            $errorMessages = ['message' => $e->getMessage()];
            $result = new JsonResponse($errorMessages, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $result;
    }
}
