<?php

namespace Athens\Core\WritableBearer;

use Athens\Core\Writable\WritableInterface;

interface WritableBearerBearerInterface
{

    /**
     * @return WritableBearerInterface
     */
    public function getWritableBearer();

    /**
     * @return WritableInterface[]
     */
    public function getWritables();

    /**
     * @param string $handle
     * @return WritableInterface|null
     */
    public function getWritableByHandle($handle);
}
