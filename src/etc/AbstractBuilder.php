<?php

namespace UWDOEM\Framework\Etc;


abstract class AbstractBuilder {

    /** @return static */
    public static function begin() {
        return new static();
    }

    /** @return $this */
    public function clear() {
        return new static();
    }

    abstract public function build();

}