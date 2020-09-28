# ControllerTester
Simple Apitte Controllers testing.

## Installation 
```shell
composer require adbros/controller-tester --dev
```

## Configuration
Just register ControllerTester in config.neon.

```yaml
services:
    - Adbros\Tester\ControllerTester\ControllerTester
```

## Usage 
```php
public function testPostHelloWorld(): void
{
    $controllerTester = $this->container->getByType(ControllerTester::class);

    $request = $controllerTester->createRequest('/api/v1/dummy/hello-world')
        ->withMethod('POST')
        ->withJsonBody([
            'foo' => 'bar',
        ]);
    $response = $controllerTester->execute($request);

    Assert::same([
        'status' => 'ok',
        'payload' => [
            'foo' => 'bar',
        ],
    ], $response->getResponse()->getJsonBody());
}
```
