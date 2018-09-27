<?php

namespace JRalph\ServerMiddleware;

use Countable;
use Iterator;
use Psr\Http\Server\MiddlewareInterface;

class MiddlewareCollection implements Iterator, Countable
{
    /**
     * The current position of the collection.
     *
     * @var int
     */
    private $position = 0;

    /**
     * @var MiddlewareInterface[]
     */
    private $middleware = [];

    public function __construct(int $position = 0)
    {
        $this->position = $position;
    }

    /**
     * Add a middleware to the collection.
     *
     * @param MiddlewareInterface $middleware
     */
    public function push(MiddlewareInterface $middleware)
    {
        $this->middleware[] = $middleware;
    }

    /**
     * Output the middleware array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->middleware;
    }

    /**
     * Return the current element
     *
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        return $this->middleware[$this->position];
    }

    /**
     * Move forward to next element
     *
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        ++$this->position;
    }

    /**
     * Return the key of the current element
     *
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * Checks if current position is valid
     *
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        return isset($this->middleware[$this->position]);
    }

    /**
     * Rewind the Iterator to the first element
     *
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * Count elements of an object
     *
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count()
    {
        return count($this->toArray());
    }
}
