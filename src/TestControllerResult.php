<?php declare(strict_types = 1);

namespace Adbros\Tester\ControllerTester;

use Apitte\Core\Http\ApiResponse;
use Tester\Assert;

class TestControllerResult
{

	private ApiResponse $response;

	public function __construct(ApiResponse $response)
	{
		$this->response = $response;
	}

	public function getResponse(): ApiResponse
	{
		return $this->response;
	}

	public function assertStatusCode(int $expected, ?string $description = null): self
	{
		Assert::same($expected, $this->getResponse()->getStatusCode(), $description);

		return $this;
	}

	/**
	 * @param mixed[] $expected
	 */
	public function assertJson(array $expected, ?string $description = null): self
	{
		Assert::same($expected, $this->getResponse()->getJsonBody(), $description);

		return $this;
	}

}
