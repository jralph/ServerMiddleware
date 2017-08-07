<?php

namespace Tests;

use JRalph\ServerMiddleware\MiddlewareCollection;
use JRalph\ServerMiddleware\Psr\Delegate;
use JRalph\ServerMiddleware\Psr\Middleware;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class MiddlewareCollectionTest extends TestCase
{
    private function getDummyMiddleware(): Middleware
    {
        $response = $this->prophesize(ResponseInterface::class);

        return new class($response->reveal()) implements Middleware {
            private $response;

            public function __construct(ResponseInterface $response)
            {
                $this->response = $response;
            }

            public function process(
                ServerRequestInterface $request,
                Delegate $delegate
            ) {
                return $this->response;
            }
        };
    }

    public function testItCanAddMiddleware()
    {
        $collection = new MiddlewareCollection();

        $collection->push($this->getDummyMiddleware());

        $this->assertEquals(1, count($collection->toArray()));
        $this->assertContainsOnlyInstancesOf(Middleware::class, $collection->toArray());

        $this->assertInstanceOf(Middleware::class, $collection->current());

        $this->assertEquals(1, count($collection->toArray()));

        $collection->push($this->getDummyMiddleware());

        $this->assertEquals(2, count($collection->toArray()));

        $this->assertEquals(0, $collection->key());
    }

    public function testItIsCountable()
    {
        $collection = new MiddlewareCollection();

        $collection->push($this->getDummyMiddleware());

        $this->assertEquals(1, count($collection));
    }
}
