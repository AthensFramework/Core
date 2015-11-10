<?php

namespace UWDOEM\Framework\Etc;

/**
 * Class AbstractBuilder is a parent class for all Builder classes.
 *
 * @package UWDOEM\Framework\Etc
 */
abstract class AbstractBuilder {

    /** @return static */
    public static function begin() {
        return new static();
    }

    /** @return $this */
    public function clear() {
        return new static();
    }

    /**
     * Returns an instance of the object type under construction.
     */
    abstract public function build();

}