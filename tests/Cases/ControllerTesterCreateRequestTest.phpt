<?php declare(strict_types = 1);

namespace Adbros\Tester\ControllerTester\Tests\Cases;

use Adbros\Tester\ControllerTester\ControllerTester;
use Adbros\Tester\ControllerTester\Tests\Fixtures\Dispatcher\FakeDispatcher;
use Apitte\Core\ErrorHandler\SimpleErrorHandler;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
class ControllerTesterCreateRequestTest extends TestCase
{

	/** @var ControllerTester */
	private $controllerTester;

	/** @var string */
	private $uri;

	/** @var mixed[] */
	private $parameters = [];

	/** @var string */
	private $method;

	/** @var string */
	private $rawBody;

	/** @var mixed[] */
	private $headers = [];

	/** @var string */
	private $protocolVersion = '2.0';

	/** @var mixed[] */
	private $serverParams = [
		'REMOTE_ADDR' => '127.0.0.1',
	];

	public function setUp(): void
	{
		parent::setUp();

		$this->controllerTester = new ControllerTester(new FakeDispatcher(), new SimpleErrorHandler());

		$this->uri = 'https://tester.dev/api/v1';
		$this->parameters = [
			'foo' => 'bar',
		];
		$this->method = 'POST';
		$this->rawBody = 'bar';
		$this->headers = [
			'bar' => 'foo',
		];
	}

	public function testRequestUri(): void
	{
		$request = $this->controllerTester->createRequest($this->uri);

		Assert::same($this->uri, $request->getUri());
		Assert::same([], $request->getParameters());
		Assert::same('GET', $request->getMethod());
		Assert::null($request->getRawBody());
		Assert::same([], $request->getHeaders());
		Assert::same('1.1', $request->getProtocolVersion());
		Assert::same([], $request->getServerParams());
	}

	public function testRequestParameters(): void
	{
		$request = $this->controllerTester->createRequest($this->uri)
			->withParameters($this->parameters);

		Assert::same($this->uri, $request->getUri());
		Assert::same($this->parameters, $request->getParameters());
		Assert::same('GET', $request->getMethod());
		Assert::null($request->getRawBody());
		Assert::same([], $request->getHeaders());
		Assert::same('1.1', $request->getProtocolVersion());
		Assert::same([], $request->getServerParams());
	}

	public function testRequestMethod(): void
	{
		$request = $this->controllerTester->createRequest($this->uri)
			->withMethod($this->method);

		Assert::same($this->uri, $request->getUri());
		Assert::same([], $request->getParameters());
		Assert::same($this->method, $request->getMethod());
		Assert::null($request->getRawBody());
		Assert::same([], $request->getHeaders());
		Assert::same('1.1', $request->getProtocolVersion());
		Assert::same([], $request->getServerParams());
	}

	public function testRequestRawBody(): void
	{
		$request = $this->controllerTester->createRequest($this->uri)
			->withRawBody($this->rawBody);

		Assert::same($this->uri, $request->getUri());
		Assert::same([], $request->getParameters());
		Assert::same('GET', $request->getMethod());
		Assert::same($this->rawBody, $request->getRawBody());
		Assert::same([], $request->getHeaders());
		Assert::same('1.1', $request->getProtocolVersion());
		Assert::same([], $request->getServerParams());
	}

	public function testRequestJsonBody(): void
	{
		$request = $this->controllerTester->createRequest($this->uri)
			->withMethod('POST')
			->withJsonBody([
				'bar' => 'foo',
			]);

		Assert::same($this->uri, $request->getUri());
		Assert::same([], $request->getParameters());
		Assert::same('POST', $request->getMethod());
		Assert::same('{"bar":"foo"}', $request->getRawBody());
		Assert::same([], $request->getHeaders());
		Assert::same('1.1', $request->getProtocolVersion());
		Assert::same([], $request->getServerParams());
	}

	public function testRequestHeaders(): void
	{
		$request = $this->controllerTester->createRequest($this->uri)
			->withHeaders($this->headers);

		Assert::same($this->uri, $request->getUri());
		Assert::same([], $request->getParameters());
		Assert::same('GET', $request->getMethod());
		Assert::null($request->getRawBody());
		Assert::same($this->headers, $request->getHeaders());
		Assert::same('1.1', $request->getProtocolVersion());
		Assert::same([], $request->getServerParams());
	}

	public function testRequestProtocolVersion(): void
	{
		$request = $this->controllerTester->createRequest($this->uri)
			->withProtocolVersion($this->protocolVersion);

		Assert::same($this->uri, $request->getUri());
		Assert::same([], $request->getParameters());
		Assert::same('GET', $request->getMethod());
		Assert::null($request->getRawBody());
		Assert::same([], $request->getHeaders());
		Assert::same($this->protocolVersion, $request->getProtocolVersion());
		Assert::same([], $request->getServerParams());
	}

	public function testRequestServerParams(): void
	{
		$request = $this->controllerTester->createRequest($this->uri)
			->withServerParams($this->serverParams);

		Assert::same($this->uri, $request->getUri());
		Assert::same([], $request->getParameters());
		Assert::same('GET', $request->getMethod());
		Assert::null($request->getRawBody());
		Assert::same([], $request->getHeaders());
		Assert::same('1.1', $request->getProtocolVersion());
		Assert::same($this->serverParams, $request->getServerParams());
	}

	public function testRequestAll(): void
	{
		$request = $this->controllerTester->createRequest($this->uri)
			->withParameters($this->parameters)
			->withMethod($this->method)
			->withRawBody($this->rawBody)
			->withHeaders($this->headers)
			->withProtocolVersion($this->protocolVersion)
			->withServerParams($this->serverParams);

		Assert::same($this->uri, $request->getUri());
		Assert::same($this->parameters, $request->getParameters());
		Assert::same($this->method, $request->getMethod());
		Assert::same($this->rawBody, $request->getRawBody());
		Assert::same($this->headers, $request->getHeaders());
		Assert::same($this->protocolVersion, $request->getProtocolVersion());
		Assert::same($this->serverParams, $request->getServerParams());
	}

}

(new ControllerTesterCreateRequestTest())
	->run();
