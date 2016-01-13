<?php

namespace UWDOEM\Framework\Etc;

/**
 * Class AbstractBuilder is a parent class for all Builder classes.
 *
 * @package UWDOEM\Framework\Etc
 */
abstract class AbstractBuilder
{

    /** @var string A unique identifier */
    protected $id;

    /** @var string[] A set of display class names */
    protected $classes = [];

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
     * Set the unique identifier for the element to be built.
     *
     * @param string $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Add a display class name to the element to be built.
     *
     * @param string $class
     * @return $this
     */
    public function addClass($class)
    {
        $this->classes[] = $class;
        return $this;
    }

    /**
     * Assert that a unique identifier has been provided for the element to be built.
     *
     * @throws \RuntimeException If id has not been set before ::build is called.
     * @return void
     */
    protected function validateId()
    {
        if ($this->id === null) {
            throw new \RuntimeException("Must use ::setId to provide a unique id before calling this method.");
        }
    }

    /**
     * Return the element under construction.
     *
     * Returns an instance of the object type under construction.
     * @return mixed
     */
    abstract public function build();
}
