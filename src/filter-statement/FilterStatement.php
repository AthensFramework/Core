<?php

namespace UWDOEM\Framework\FilterStatement;

use Propel\Runtime\ActiveQuery\ModelCriteria;
use UWDOEM\Framework\Row\RowInterface;

abstract class FilterStatement implements FilterStatementInterface
{

    /** @var string */
    protected $_fieldName;

    /** @var string */
    protected $_condition;

    /** @var  mixed */
    protected $_criterion;

    /** @var  mixed */
    protected $_control;


    /**
     * FilterStatement constructor.
     * @param string $_fieldName
     * @param string $_condition
     * @param mixed $_criterion
     * @param $_control
     */
    public function __construct($_fieldName, $_condition, $_criterion, $_control)
    {
        $this->_fieldName = $_fieldName;
        $this->_condition = $_condition;
        $this->_criterion = $_criterion;
        $this->_control = $_control;
    }

    /**
     * @return string
     */
    public function getFieldName()
    {
        return $this->_fieldName;
    }

    /**
     * @return string
     */
    public function getCondition()
    {
        return $this->_condition;
    }

    /**
     * @return mixed
     */
    public function getCriterion()
    {
        return $this->_criterion;
    }

    /**
     * @return mixed
     */
    public function getControl()
    {
        return $this->_control;
    }

    /**
     * @param ModelCriteria $query
     * @return ModelCriteria
     */
    abstract public function applyToQuery(ModelCriteria $query);

    /**
     * @param RowInterface[] $rows
     * @return RowInterface[]
     */
    abstract public function applyToRows(array $rows);
}
