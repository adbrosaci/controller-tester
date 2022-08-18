<?php declare(strict_types = 1);

namespace Adbros\Tester\ControllerTester\Tests\Cases;

use Adbros\Tester\ControllerTester\ControllerTester;
use Adbros\Tester\ControllerTester\Tests\Fixtures\Dispatcher\FakeDispatcher;
use Apitte\Core\ErrorHandler\SimpleErrorHandler;
use Tester\TestCase;

require __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
class ControllerTesterExecuteTest extends TestCase
{

	/** @var ControllerTester */
	private $controllerTester;

	public function setUp(): void
	{
		parent::setUp();

		$this->controllerTester = new ControllerTester(new FakeDispatcher(), new SimpleErrorHandler());
	}

	public function testRequestUri(): void
	{
		$request = $this->controllerTester->createRequest('https://tester.dev/api/v1');
		$result = $this->controllerTester->execute($request);

		$result->assertStatusCode(200);
		$result->assertJson([]);
	}

}

(new ControllerTesterExecuteTest())
	->run();
