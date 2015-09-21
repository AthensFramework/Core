<?php

namespace UWDOEM\Framework\Filter;


class FilterStatement implements FilterStatementInterface {

    /** @var string */
    protected $_fieldName;

    /** @var string */
    protected $_condition;

    /** @var  mixed */
    protected $_criterion;


    /**
     * FilterStatement constructor.
     * @param string $_fieldName
     * @param string $_condition
     * @param mixed $_criterion
     */
    public function __construct($_fieldName, $_condition, $_criterion) {
        $this->_fieldName = $_fieldName;
        $this->_condition = $_condition;
        $this->_criterion = $_criterion;
    }


    /**
     * @return string
     */
    public function getFieldName() {
        return $this->_fieldName;
    }

    /**
     * @return string
     */
    public function getCondition() {
        return $this->_condition;
    }

    /**
     * @return mixed
     */
    public function getCriterion() {
        return $this->_criterion;
    }


}