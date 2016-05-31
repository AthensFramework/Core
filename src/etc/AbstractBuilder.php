<?php

namespace Athens\Core\Etc;

/**
 * Class AbstractBuilder is a parent class for all Builder classes.
 *
 * @package Athens\Core\Etc
 */
abstract class AbstractBuilder
{

    /** @var string A unique identifier */
    protected $id;

    /** @var string[] A set of display class names */
    protected $classes = [];

    /** @var string[] An associative array of extra data fields to attach to the object */
    protected $data = [];

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
     * Add a data field to the element to be built.
     *
     * For example, when building a field:
     *
     * FieldBuilder->begin()
     *     ->addData('owned-by', 'bob')
     *     ...
     *     ->build();
     *
     * When written to HTML, the resulting field will have
     * an HTML5 data attribute like:
     *
     *     <... data-owned-by='bob' .../>
     *
     * @param string $key
     * @param string $value
     * @return $this
     */
    public function addData($key, $value)
    {
        $this->data[$key] = $value;
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
