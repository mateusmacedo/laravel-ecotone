<?php

declare(strict_types=1);

namespace Module\Users\Infrastructure\Http\Controllers\Illuminate;

use Ecotone\Modelling\CommandBus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Module\Core\Domain\Exception\ValidationExceptions;
use Module\Users\Application\Factories\UserCommandQueryFactory;
use Module\Users\Application\Factories\UserDtoFactory;
use Symfony\Component\HttpFoundation\Response;

class ChangePasswordController extends Controller
{
    public function __construct(
        private UserDtoFactory $dtoFactory,
        private UserCommandQueryFactory $commandQueryFactory,
        private CommandBus $commandBus
    ) {
    }

    public function patch(Request $request)
    {
        $dto = $this->dtoFactory->changePasswordDto($request->all());
        $command = $this->commandQueryFactory->ChangePasswordCommand($dto);
        try {
            $this->commandBus->send($command);
        } catch (ValidationExceptions $e) {
            $errorMessages = ['message' => $e->extractErrorMessages()];
            return new JsonResponse($errorMessages, Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            $errorMessages = ['message' => $e->getMessage()];
            return new JsonResponse($errorMessages, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return new Response(null, Response::HTTP_CREATED);
    }
}
