<?php

namespace Athens\Core\Row;

use Athens\Core\WritableBearer\WritableBearerBearerInterface;
use Athens\Core\Writable\WritableInterface;

interface RowInterface extends WritableInterface, WritableBearerBearerInterface
{
    /**
     * @return string
     */
    public function getOnClick();

    /**
     * @return string[]
     */
    public function getLabels();

    /**
     * @return boolean
     */
    public function isHighlightable();
}
