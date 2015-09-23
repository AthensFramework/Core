<?php

namespace UWDOEM\Framework\Filter;

use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\Criteria;
use UWDOEM\Framework\Row\RowInterface;


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

    public function applyToQuery(ModelCriteria $query) {
        $cond = $this->getCondition();
        $fieldName = $this->getFieldName();

        switch ($cond) {
            case static::COND_SORT_ASC:
                $query = $query->orderBy($fieldName, Criteria::ASC);
                break;
            case static::COND_SORT_DESC:
                $query = $query->orderBy($fieldName, Criteria::DESC);
                break;
            case static::COND_LESS_THAN:

                break;
            case static::COND_GREATER_THAN:

                break;
            case static::COND_EQUAL_TO:

                break;
            case static::COND_NOT_EQUAL_TO:

                break;
            case static::COND_CONTAINS:

                break;
            case static::COND_PAGINATE_BY:

                break;
        }

        return $query;
    }

    public function applyToRows(array $rows) {

        return $rows;
    }


}