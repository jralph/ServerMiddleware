# Server Middleware Dispatcher

[![Build Status](https://travis-ci.org/jralph/ServerMiddleware.svg)](https://travis-ci.org/jralph/ServerMiddleware)
[![Coverage Status](https://coveralls.io/repos/github/jralph/ServerMiddleware/badge.svg?branch=master)](https://coveralls.io/github/jralph/ServerMiddleware?branch=master)
[![Mutation testing badge](https://badge.stryker-mutator.io/github.com/jralph/ServerMiddleware/master)](https://stryker-mutator.github.io)

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/c2f0d7b4-7ba8-4e97-b86f-6ca3f0f62dae/big.png)](https://insight.sensiolabs.com/projects/c2f0d7b4-7ba8-4e97-b86f-6ca3f0f62dae)

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
           * Implementations of Psr\Http\Server\MiddlewareInterface
           */
          
          $firstMiddleware,
          $secondMiddleware,
          $thirdMiddleware
          
    );

/** @var \Psr\Http\Message\ServerRequestInterface $request */
$request = new Request;

$response = $dispatcher->handle($request);
```
