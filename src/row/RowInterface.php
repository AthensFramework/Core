<?php

namespace UWDOEM\Framework\Row;

use UWDOEM\Framework\FieldBearer\FieldBearerInterface;
use UWDOEM\Framework\Writer\WritableInterface;

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
