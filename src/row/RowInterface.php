<?php

namespace UWDOEM\Framework\Row;


use UWDOEM\Framework\FieldBearer\FieldBearerInterface;
use UWDOEM\Framework\Writer\WritableInterface;


interface RowInterface extends WritableInterface {

    /**
     * @return FieldBearerInterface
     */
    function getFieldBearer();

    /**
     * @return string
     */
    function getOnClick();

}