<?php

namespace Athens\Core\Link;

use Athens\Core\Writable\WritableInterface;

interface LinkInterface extends WritableInterface
{
    /** @return string */
    public function getLink();

    /** @return string */
    public function getText();
}
