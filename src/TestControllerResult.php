<?php declare(strict_types = 1);

namespace Adbros\Tester\ControllerTester;

use Apitte\Core\Http\ApiResponse;
use Tester\Assert;

class TestControllerResult
{

	/** @var ApiResponse */
	private $response;

	public function __construct(ApiResponse $response)
	{
		$this->response = $response;
	}

	public function getResponse(): ApiResponse
	{
		return $this->response;
	}

	public function assertStatusCode(int $expected): self
	{
		Assert::same($expected, $this->getResponse()->getStatusCode());

		return $this;
	}

	/**
	 * @param mixed[] $expected
	 */
	public function assertJson(array $expected): self
	{
		Assert::same($expected, $this->getResponse()->getJsonBody());

		return $this;
	}

}
