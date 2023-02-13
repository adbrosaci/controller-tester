<?php declare(strict_types = 1);

namespace Adbros\Tester\ControllerTester;

use Apitte\Core\Dispatcher\DispatchError;
use Apitte\Core\Dispatcher\IDispatcher;
use Apitte\Core\ErrorHandler\IErrorHandler;
use Apitte\Core\Http\ApiRequest;
use Apitte\Core\Http\ApiResponse;
use Contributte\Middlewares\Application\IApplication;
use Contributte\Psr7\Psr7Response;
use Contributte\Psr7\Psr7ServerRequest;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class ControllerTester
{

	private IDispatcher $dispatcher;

	private IErrorHandler $errorHandler;

	private ?IApplication $middlewaresApplication = null;

	public function __construct(IDispatcher $dispatcher, IErrorHandler $errorHandler, ?IApplication $middlewaresApplication = null)
	{
		$this->dispatcher = $dispatcher;
		$this->errorHandler = $errorHandler;
		$this->middlewaresApplication = $middlewaresApplication;
	}

	public function createRequest(string $uri): TestControllerRequest
	{
		return new TestControllerRequest($uri);
	}

	public function execute(TestControllerRequest $testControllerRequest): TestControllerResult
	{
		$request = $this->createApiRequest($testControllerRequest);
		$response = new ApiResponse(new Psr7Response());

		if ($this->middlewaresApplication !== null && method_exists($this->middlewaresApplication, 'runWith')) {
			ob_start();
			$response = $this->middlewaresApplication->runWith($request);
			ob_end_clean();

			if (!$response instanceof ResponseInterface) {
				throw new Exception(sprintf('Unsupported type of response: \'%s\'.', gettype($response)));
			}

			return new TestControllerResult(new ApiResponse($response));
		}

		try {
			$response = $this->dispatcher->dispatch($request, $response);
		} catch (Throwable $exception) {
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

		if ($testControllerRequest->getParsedBody() !== null) {
			$request = $request->withParsedBody($testControllerRequest->getParsedBody());
		}

		return new ApiRequest($request);
	}

}
