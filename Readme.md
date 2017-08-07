# Server Middleware Dispatcher

[![Build Status](https://travis-ci.org/jralph/ServerMiddleware.svg)](https://travis-ci.org/jralph/ServerMiddleware)
[![Coverage Status](https://coveralls.io/repos/github/jralph/ServerMiddleware/badge.svg?branch=master)](https://coveralls.io/github/jralph/ServerMiddleware?branch=master)

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/ef0f5a33-a471-49b7-aac1-6b9e6fcb06ed/big.png)](https://insight.sensiolabs.com/projects/ef0f5a33-a471-49b7-aac1-6b9e6fcb06ed)

A PSR-15 compliant server middleware dispatcher implementation.

## Goal

The goal of this package is to implement the (currently in draft) PSR-15 spec for middleware in as simple a way as possible.

The entire package **MUST** be covered by tests.

## Usage

See [PSR-15](https://github.com/php-fig/fig-standards/blob/master/proposed/http-middleware/middleware.md) spec for more detailed info on implementing middleware.

```php
<?php

use JRalph\ServerMiddleware\Dispatcher;

$dispatcher = (new Dispatcher())
    ->addMiddleware(
        
          /**
           * Implementations of JRalph\ServerMiddleware\Psr\Middleware
           * To be chanegd once PSR-15 is out of draft.
           */
          
          $firstMiddleware,
          $secondMiddleware,
          $thirdMiddleware
          
    );

/** @var \Psr\Http\Message\ServerRequestInterface $request */
$request = new Request;

$response = $dispatcher->process($request);
```

## Note

The interfaces `JRalph\ServerMiddleware\Psr\Delegate` and `JRalph\ServerMiddleware\Psr\Middleware` will be replaced by the official interfaces once the spec has passed draft.
