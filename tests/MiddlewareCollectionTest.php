<?php

namespace Tests;

use JRalph\ServerMiddleware\MiddlewareCollection;
use Psr\Http\Server\MiddlewareInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class MiddlewareCollectionTest extends TestCase
{
    private function getDummyMiddleware(): MiddlewareInterface
    {
        $response = $this->prophesize(ResponseInterface::class);

        return new class($response->reveal()) implements MiddlewareInterface {
            private $response;

            public function __construct(ResponseInterface $response)
            {
                $this->response = $response;
            }

            public function process(
                ServerRequestInterface $request,
                RequestHandlerInterface $delegate
            ): ResponseInterface {
                return $this->response;
            }
        };
    }

    public function testItCanAddMiddleware()
    {
        $collection = new MiddlewareCollection();

        $collection->push($this->getDummyMiddleware());

        $this->assertEquals(1, count($collection->toArray()));
        $this->assertContainsOnlyInstancesOf(MiddlewareInterface::class, $collection->toArray());

        $this->assertInstanceOf(MiddlewareInterface::class, $collection->current());

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
