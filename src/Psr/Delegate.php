<?php

namespace  JRalph\ServerMiddleware\Psr;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface Delegate /* extends Psr\Http\ServerMiddleware\DelegateInterface */
{
    /**
     * Dispatch the next available middleware and return the response.
     *
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request);
}