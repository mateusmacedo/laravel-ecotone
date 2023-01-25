<?php

declare(strict_types=1);

namespace Module\Users\Infrastructure\Http\Controllers\Illuminate;

use Ecotone\Modelling\CommandBus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Module\Core\Domain\Exception\ValidationExceptions;
use Symfony\Component\HttpFoundation\Response;
use Module\Users\Application\Factories\UserCommandQueryFactory;
use Module\Users\Application\Factories\UserDtoFactory;

class RegisterController extends Controller
{
	public function __construct(
		private UserDtoFactory $dtoFactory,
		private UserCommandQueryFactory $commandQueryFactory,
		private CommandBus $commandBus
	)
	{}

	public function post(Request $request) {
		$dto = $this->dtoFactory->registerDto($request->all());
		$command = $this->commandQueryFactory->registerCommand($dto);
		try{
			$this->commandBus->send($command);
		} catch (ValidationExceptions $e) {
			$errorMessages = ['message' => $e->extractErrorMessages()];
            return new JsonResponse($errorMessages, Response::HTTP_UNPROCESSABLE_ENTITY);
		}
        return new Response(null, Response::HTTP_CREATED);
	}
}