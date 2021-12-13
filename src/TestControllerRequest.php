<?php declare(strict_types = 1);

namespace Adbros\Tester\ControllerTester;

use Nette\SmartObject;
use Nette\Utils\Json;

class TestControllerRequest
{

	use SmartObject;

	/**	@var string */
	private $uri;

	/**	@var mixed[] */
	private $parameters = [];

	/** @var string */
	private $method = 'GET';

	/** @var string|null */
	private $rawBody;

	/** @var mixed[] */
	private $headers = [];

	/** @var string */
	private $protocolVersion = '1.1';

	/** @var mixed[] */
	private $serverParams = [];

	public function __construct(string $uri)
	{
		$this->uri = $uri;
	}

	public function getUri(): string
	{
		return $this->uri;
	}

	/**
	 * @return mixed[]
	 */
	public function getParameters(): array
	{
		return $this->parameters;
	}

	public function getMethod(): string
	{
		return $this->method;
	}

	public function getRawBody(): ?string
	{
		return $this->rawBody;
	}

	/**
	 * @return mixed[]
	 */
	public function getHeaders(): array
	{
		return $this->headers;
	}

	public function getProtocolVersion(): string
	{
		return $this->protocolVersion;
	}

	/**
	 * @return mixed[]
	 */
	public function getServerParams(): array
	{
		return $this->serverParams;
	}

	/**
	 * @param mixed[] $parameters
	 */
	public function withParameters(array $parameters): TestControllerRequest
	{
		$request = clone $this;
		$request->parameters = $parameters + $request->parameters;

		return $request;
	}

	public function withMethod(string $method): TestControllerRequest
	{
		$request = clone $this;
		$request->method = $method;

		return $request;
	}

	public function withRawBody(string $body): TestControllerRequest
	{
		$request = clone $this;
		$request->rawBody = $body;

		return $request;
	}

	/**
	 * @param mixed[] $body
	 */
	public function withJsonBody(array $body): TestControllerRequest
	{
		$request = clone $this;
		$request->rawBody = Json::encode($body);

		return $request;
	}

	/**
	 * @param mixed[] $headers
	 */
	public function withHeaders(array $headers): TestControllerRequest
	{
		$request = clone $this;
		$request->headers = array_change_key_case($headers, CASE_LOWER) + $request->headers;

		return $request;
	}

	public function withProtocolVersion(string $protocolVersion): TestControllerRequest
	{
		$request = clone $this;
		$request->protocolVersion = $protocolVersion;

		return $request;
	}

	/**
	 * @param mixed[] $serverParams
	 */
	public function withServerParams(array $serverParams): TestControllerRequest
	{
		$request = clone $this;
		$request->serverParams = $serverParams;

		return $request;
	}

}
