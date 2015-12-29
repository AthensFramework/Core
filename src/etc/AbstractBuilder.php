<?php

namespace UWDOEM\Framework\Etc;

/**
 * Class AbstractBuilder is a parent class for all Builder classes.
 *
 * @package UWDOEM\Framework\Etc
 */
abstract class AbstractBuilder
{

    /** @var string */
    protected $id;

    /** @return static */
    public static function begin()
    {
        return new static();
    }

    /** @return $this */
    public function clear()
    {
        return new static();
    }

    /**
     * @param string $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @throws \RuntimeException If id has not been set before ::build is called.
     * @return void
     */
    protected function validateId()
    {
        if ($this->id === null) {
            throw new \RuntimeException("Must use ::setId to provide a form id before calling this method.");
        }
    }

    /**
     * Returns an instance of the object type under construction.
     * @return mixed
     */
    abstract public function build();
}
