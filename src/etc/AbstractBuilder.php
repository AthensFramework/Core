<?php

namespace Athens\Core\Etc;

/**
 * Class AbstractBuilder is a parent class for all Builder classes.
 *
 * @package Athens\Core\Etc
 */
abstract class AbstractBuilder
{
    /** @return static Return a new builder */
    public static function begin()
    {
        return new static();
    }

    /** @return $this Return a new builder */
    public function clear()
    {
        return new static();
    }

    /**
     * Return the element under construction.
     *
     * Returns an instance of the object type under construction.
     * @return mixed
     */
    abstract public function build();
}
