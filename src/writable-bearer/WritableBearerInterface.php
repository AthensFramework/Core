<?php

namespace Athens\Core\WritableBearer;

use Athens\Core\Initializer\InitializableInterface;
use Athens\Core\Writable\WritableInterface;

interface WritableBearerInterface extends InitializableInterface, WritableInterface
{

    /**
     * @return WritableInterface[]
     */
    public function getWritables();
}
