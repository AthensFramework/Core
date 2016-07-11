<?php

namespace Athens\Core\Link;

use Athens\Core\Writable\WritableInterface;

interface LinkInterface extends WritableInterface
{

    /** @return string */
    public function getURI();

    /** @return string */
    public function getText();
}
