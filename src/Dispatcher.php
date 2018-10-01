<?php

namespace JRalph\ServerMiddleware;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Dispatcher implements RequestHandlerInterface
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
     * @return $this
     */
    public function addMiddleware(MiddlewareInterface ...$middleware): self
    {
        foreach ($middleware as $item) {
            $this->middleware->push($item);
        }

        return $this;
    }

    /**
     * Dispatch the next available middleware and return the response.
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->middleware->next();

        if ($this->middleware->valid()) {
            $response = $this->middleware->current()->process($request, $this);
        }

        $this->middleware->set(-1);

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
