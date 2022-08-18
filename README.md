# ControllerTester
Simple Apitte Controllers testing.

---

[![main workflow](https://github.com/adbrosaci/controller-tester/actions/workflows/main.yml/badge.svg)](https://github.com/adbrosaci/controller-tester/actions/workflows/main.yml)
[![Code coverage](https://img.shields.io/coveralls/adbrosaci/controller-tester.svg?style=flat-square)](https://coveralls.io/r/adbrosaci/controller-tester)
[![Licence](https://img.shields.io/packagist/l/adbros/controller-tester.svg?style=flat-square)](https://packagist.org/packages/adbros/controller-tester)
[![Downloads this Month](https://img.shields.io/packagist/dm/adbros/controller-tester.svg?style=flat-square)](https://packagist.org/packages/adbros/controller-tester)
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
Add QUERY parameters.

### `withMethod(string $method)`
Set HTTP method. Default method is `GET`.

### `withRawBody(string $body)`
Set request RAW body.

### `withJsonBody(array $body)`
Set request JSON body.

### `withParsedBody(array $body)`
Set POST request with parsed body like x-www-form-urlencoded.

### `withFile(string $name, string $filePath)`
Add file - Psr7UploadedFile

### `withHeaders(array $headers)`
Add HTTP headers.

### `withProtocolVersion(string $protocolVersion)`
Set HTTP protocol version. Default protocol version is `1.1`.

### `withServerParams(array $serverParams)`
Add SERVER parameters.
