# ControllerTester
Simple Apitte Controllers testing.

---

[![Build Status](https://img.shields.io/travis/com/adbrosaci/controller-tester.svg?style=flat-square)](https://travis-ci.com/adbrosaci/controller-tester)
[![Licence](https://img.shields.io/packagist/l/adbros/controller-tester.svg?style=flat-square)](https://packagist.org/packages/adbros/controller-tester)
[![Downloads this Month](https://img.shields.io/packagist/dm/adbros/controller-tester.svg?style=flat-square)](https://packagist.org/packages/adbros/google)
[![Downloads total](https://img.shields.io/packagist/dt/adbros/controller-tester.svg?style=flat-square)](https://packagist.org/packages/adbros/controller-tester)
[![Latest stable](https://img.shields.io/packagist/v/adbros/controller-tester.svg?style=flat-square)](https://packagist.org/packages/adbros/controller-tester) 

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
    $result = $controllerTester->execute($request);

    $result->assertJson([
        'status' => 'ok',
        'payload' => [
            'foo' => 'bar',
        ],
    ]);
    $result->assertStatusCode(200);
}
```

## TestControllerRequest API
TestControllerRequest is **immutable** object.

### `withParameters(array $parameters)`
### `withMethod(string $method)`
### `withRawBody(string $body)`
### `withJsonBody(array $body)`
### `withHeaders(array $headers)`
