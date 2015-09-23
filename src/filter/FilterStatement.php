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

    /** @var  mixed */
    protected $_control;


    /**
     * FilterStatement constructor.
     * @param string $_fieldName
     * @param string $_condition
     * @param mixed $_criterion
     * @param $_control
     */
    public function __construct($_fieldName, $_condition, $_criterion, $_control) {
        $this->_fieldName = $_fieldName;
        $this->_condition = $_condition;
        $this->_criterion = $_criterion;
        $this->_control = $_control;
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

    /**
     * @return mixed
     */
    public function getControl() {
        return $this->_control;
    }

    public function applyToQuery(ModelCriteria $query) {
        $cond = $this->getCondition();
        $fieldName = $this->getFieldName();

        $criterion = $this->getCriterion();
        $control = $this->getControl();

        switch ($cond) {
            case static::COND_SORT_ASC:
                $query = $query->orderBy($fieldName, Criteria::ASC);
                break;
            case static::COND_SORT_DESC:
                $query = $query->orderBy($fieldName, Criteria::DESC);
                break;
            case static::COND_LESS_THAN:
                $query = $query->addUsingAlias($fieldName, $criterion, Criteria::LESS_THAN);
                break;
            case static::COND_GREATER_THAN:
                $query = $query->addUsingAlias($fieldName, $criterion, Criteria::GREATER_THAN);
                break;
            case static::COND_EQUAL_TO:
                $query = $query->addUsingAlias($fieldName, $criterion, Criteria::EQUAL);
                break;
            case static::COND_NOT_EQUAL_TO:
                $query = $query->addUsingAlias($fieldName, $criterion, Criteria::NOT_EQUAL);
                break;
            case static::COND_CONTAINS:
                $query = $query->addUsingAlias($fieldName, [$criterion], Criteria::CONTAINS_ALL);
                break;
            case static::COND_PAGINATE_BY:
                $page = $control;
                $maxPerPage = $criterion;

                $query = $query->offset(($page - 1) * $maxPerPage)->limit($maxPerPage);
                break;
        }

        return $query;
    }

    /**
     * @param RowInterface[] $rows
     * @return RowInterface[]
     */
    public function applyToRows(array $rows) {
        $fieldName = $this->getFieldName();
        $cond = $this->getCondition();
        $criterion = $this->getCriterion();
        $control = $this->getControl();

        $getFieldValueFunction = function ($row) use ($fieldName) {
            /** @var RowInterface $row */
            return $row->getFieldBearer()->getFieldByName($fieldName)->getInitial();
        };

        switch ($cond) {
            case static::COND_SORT_ASC:
                $compare = function (RowInterface $a, RowInterface $b) use ($getFieldValueFunction) {
                    $valA = $getFieldValueFunction($a);
                    $valB = $getFieldValueFunction($b);

                    return $valA - $valB;
                };

                uasort($rows, $compare);

                break;
            case static::COND_SORT_DESC:

                $compare = function (RowInterface $a, RowInterface $b) use ($getFieldValueFunction) {
                    $valA = $getFieldValueFunction($a);
                    $valB = $getFieldValueFunction($b);

                    return $valB - $valA;
                };

                uasort($rows, $compare);

                break;
            case static::COND_LESS_THAN:
                $filter = function (RowInterface $row) use ($getFieldValueFunction, $criterion) {
                    $val = $getFieldValueFunction($row);

                    return $val < $criterion;
                };

                $rows = array_filter($rows, $filter);
                break;
            case static::COND_GREATER_THAN:
                $filter = function (RowInterface $row) use ($getFieldValueFunction, $criterion) {
                    $val = $getFieldValueFunction($row);

                    return $val > $criterion;
                };

                $rows = array_filter($rows, $filter);

                break;
            case static::COND_EQUAL_TO:
                $filter = function (RowInterface $row) use ($getFieldValueFunction, $criterion) {
                    $val = $getFieldValueFunction($row);

                    return $val === $criterion;
                };

                $rows = array_filter($rows, $filter);

                break;
            case static::COND_NOT_EQUAL_TO:
                $filter = function (RowInterface $row) use ($getFieldValueFunction, $criterion) {
                    $val = $getFieldValueFunction($row);

                    return $val !== $criterion;
                };

                $rows = array_filter($rows, $filter);

                break;
            case static::COND_CONTAINS:
                $filter = function (RowInterface $row) use ($getFieldValueFunction, $criterion) {
                    $val = $getFieldValueFunction($row);

                    return strripos($val, $criterion) !== false;
                };

                $rows = array_filter($rows, $filter);

                break;
            case static::COND_PAGINATE_BY:
                $page = $control;
                $maxPerPage = $criterion;

                $rows = array_slice($rows, ($page - 1)*$maxPerPage, $maxPerPage);

                break;
        }

        return $rows;
    }


}