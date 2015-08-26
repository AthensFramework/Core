<?php

namespace UWDOEM\Framework\Row;


use UWDOEM\Framework\FieldBearer\FieldBearerInterface;


interface RowInterface {

    /**
     * @return FieldBearerInterface
     */
    function getFieldBearer();

    /**
     * @return string
     */
    function getOnClick();

}