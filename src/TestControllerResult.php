<?php declare(strict_types = 1);

namespace Adbros\Tester\ControllerTester;

use Apitte\Core\Http\ApiResponse;

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

}
