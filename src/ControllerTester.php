<?php declare(strict_types = 1);

namespace Adbros\Tester\ControllerTester;

use Apitte\Core\Dispatcher\DispatchError;
use Apitte\Core\Dispatcher\IDispatcher;
use Apitte\Core\ErrorHandler\IErrorHandler;
use Apitte\Core\Http\ApiRequest;
use Apitte\Core\Http\ApiResponse;
use Contributte\Psr7\Psr7Response;
use Contributte\Psr7\Psr7ServerRequest;
use Throwable;

class ControllerTester
{

	/** @var IDispatcher */
	private $dispatcher;

	/** @var IErrorHandler */
	private $errorHandler;

	public function __construct(IDispatcher $dispatcher, IErrorHandler $errorHandler)
	{
		$this->dispatcher = $dispatcher;
		$this->errorHandler = $errorHandler;
	}

	public function createRequest(string $uri): TestControllerRequest
	{
		return new TestControllerRequest($uri);
	}

	public function execute(TestControllerRequest $testControllerRequest): TestControllerResult
	{
		$request = $this->createApiRequest($testControllerRequest);
		$response = new ApiResponse(new Psr7Response());

		try {
			$response = $this->dispatcher->dispatch($request, $response);
		} catch (Throwable $exception) {
			if (!class_exists(DispatchError::class)) {
				// compatibility with version <0.7
				throw $exception;
			}

			$response = $this->errorHandler->handle(new DispatchError($exception, $request));
		}

		return new TestControllerResult($response);
	}

	protected function createApiRequest(TestControllerRequest $testControllerRequest): ApiRequest
	{
		$request = (new Psr7ServerRequest(
			$testControllerRequest->getMethod(),
			$testControllerRequest->getUri(),
			$testControllerRequest->getHeaders(),
			$testControllerRequest->getRawBody(),
			$testControllerRequest->getProtocolVersion(),
			$testControllerRequest->getServerParams()
		))->withQueryParams($testControllerRequest->getParameters());

		if (count($testControllerRequest->getFiles()) > 0) {
			$request = $request->withUploadedFiles($testControllerRequest->getFiles());
		}

		return new ApiRequest($request);
	}

}
