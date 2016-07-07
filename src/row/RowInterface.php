<?php

namespace Athens\Core\Row;

use Athens\Core\FieldBearer\FieldBearerInterface;
use Athens\Core\Writable\WritableInterface;

interface RowInterface extends WritableInterface
{

    /**
     * @return FieldBearerInterface
     */
    public function getFieldBearer();

    /**
     * @return string
     */
    public function getOnClick();

    /**
     * @return boolean
     */
    public function isHighlightable();
}
