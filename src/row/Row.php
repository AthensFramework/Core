<?php

namespace UWDOEM\Framework\Row;


use UWDOEM\Framework\FieldBearer\FieldBearerInterface;
use UWDOEM\Framework\Visitor\VisitableTrait;


/**
 * A Table child which contains fields
 *
 * @package UWDOEM\Framework\Table\Row
 */
class Row implements RowInterface {

    /**
     * A string containing the javascript action to take when this row is clicked.
     *
     * @var string
     */
    protected $_onClick;

    /**
     * @var FieldBearerInterface
     */
    protected $_fieldBearer;

    use VisitableTrait;


    function __construct(FieldBearerInterface $fieldBearer, $onClick) {
        $this->_fieldBearer = $fieldBearer;
        $this->_onClick = $onClick;
    }

    /**
     * @return string
     */
    public function getOnClick()
    {
        return $this->_onClick;
    }

    /**
     * @return FieldBearerInterface
     */
    public function getFieldBearer()
    {
        return $this->_fieldBearer;
    }




}