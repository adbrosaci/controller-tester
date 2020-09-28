<?php declare(strict_types = 1);

namespace Adbros\Tester\ControllerTester;

use Apitte\Core\Dispatcher\IDispatcher;
use Apitte\Core\Http\ApiRequest;
use Apitte\Core\Http\ApiResponse;
use Apitte\Core\Router\IRouter;
use Contributte\Psr7\Psr7Response;
use Contributte\Psr7\Psr7ServerRequest;

class ControllerTester
{

	/** @var IRouter */
	private $router;

	/** @var IDispatcher */
	private $dispatcher;

	public function __construct(IRouter $router, IDispatcher $dispatcher)
	{
		$this->router = $router;
		$this->dispatcher = $dispatcher;
	}

	public function createRequest(string $uri): TestControllerRequest
	{
		return new TestControllerRequest($uri);
	}

	public function execute(TestControllerRequest $testControllerRequest): TestControllerResult
	{
		$request = $this->createApiRequest($testControllerRequest);
		$response = new ApiResponse(new Psr7Response());
		$response = $this->dispatcher->dispatch($request, $response);

		return new TestControllerResult($response);
	}

	protected function createApiRequest(TestControllerRequest $testControllerRequest): ApiRequest
	{
		return new ApiRequest(new Psr7ServerRequest(
			$testControllerRequest->getMethod(),
			$testControllerRequest->getUri(),
			$testControllerRequest->getHeaders(),
			$testControllerRequest->getRawBody()
		));
	}

}
