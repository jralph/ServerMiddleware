<?php

namespace  JRalph\ServerMiddleware\Psr;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface Middleware /* extends Psr\Http\ServerMiddleware\MiddlewareInterface */
{
    /**
     * Process an incoming server request and return a response, optionally delegating
     * to the next middleware component to create the response.
     *
     * @param ServerRequestInterface $request
     * @param Delegate $delegate
     *
     * @return ResponseInterface
     */
    public function process(
        ServerRequestInterface $request,
        Delegate $delegate
    );
}