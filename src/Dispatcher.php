<?php

namespace JRalph\ServerMiddleware;

use GuzzleHttp\Psr7\Response;
use JRalph\ServerMiddleware\Psr\DelegateInterface;
use JRalph\ServerMiddleware\Psr\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Dispatcher implements DelegateInterface
{
    /**
     * @var MiddlewareCollection
     */
    private $middleware;

    public function __construct()
    {
        // Set to -1 for first process call to use first middleware.
        $this->middleware = new MiddlewareCollection(-1);
    }

    /**
     * @return MiddlewareCollection
     */
    public function getMiddleware(): MiddlewareCollection
    {
        return $this->middleware;
    }

    /**
     * @param MiddlewareInterface|MiddlewareInterface[] ...$middleware
     */
    public function addMiddleware(MiddlewareInterface ...$middleware)
    {
        foreach ($middleware as $item) {
            $this->middleware->push($item);
        }
    }

    /**
     * Dispatch the next available middleware and return the response.
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws \Exception
     */
    public function process(ServerRequestInterface $request)
    {
        $this->middleware->next();

        if ($this->middleware->valid()) {
            $response = $this->middleware->current()->process($request, $this);
        }

        return $response ?? $this->getDefaultResponse();
    }

    /**
     * @return ResponseInterface
     */
    private function getDefaultResponse(): ResponseInterface
    {
        return new Response(500);
    }
}
