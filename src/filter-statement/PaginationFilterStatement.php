<?php

namespace UWDOEM\Framework\FilterStatement;

use Propel\Runtime\ActiveQuery\ModelCriteria;


class PaginationFilterStatement extends FilterStatement {

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

    public function applyToRows(array $rows) {
        $fieldName = $this->getFieldName();
        $cond = $this->getCondition();
        $criterion = $this->getCriterion();
        $control = $this->getControl();

        $getFieldValue = function ($row) use ($fieldName) {
            /** @var RowInterface $row */
            return $row->getFieldBearer()->getFieldByName($fieldName)->getInitial();
        };

        switch ($cond) {
            case static::COND_SORT_ASC:
                $compare = function (RowInterface $a, RowInterface $b) use ($getFieldValue) {
                    $valA = $getFieldValue($a);
                    $valB = $getFieldValue($b);

                    return $valA - $valB;
                };

                uasort($rows, $compare);

                break;
            case static::COND_SORT_DESC:

                $compare = function (RowInterface $a, RowInterface $b) use ($getFieldValue) {
                    $valA = $getFieldValue($a);
                    $valB = $getFieldValue($b);

                    return $valB - $valA;
                };

                uasort($rows, $compare);

                break;
            case static::COND_LESS_THAN:
                $filter = function (RowInterface $row) use ($getFieldValue, $criterion) {
                    $val = $getFieldValue($row);

                    return $val < $criterion;
                };

                $rows = array_filter($rows, $filter);
                break;
            case static::COND_GREATER_THAN:
                $filter = function (RowInterface $row) use ($getFieldValue, $criterion) {
                    $val = $getFieldValue($row);

                    return $val > $criterion;
                };

                $rows = array_filter($rows, $filter);

                break;
            case static::COND_EQUAL_TO:
                $filter = function (RowInterface $row) use ($getFieldValue, $criterion) {
                    $val = $getFieldValue($row);

                    return $val === $criterion;
                };

                $rows = array_filter($rows, $filter);

                break;
            case static::COND_NOT_EQUAL_TO:
                $filter = function (RowInterface $row) use ($getFieldValue, $criterion) {
                    $val = $getFieldValue($row);

                    return $val !== $criterion;
                };

                $rows = array_filter($rows, $filter);

                break;
            case static::COND_CONTAINS:
                $filter = function (RowInterface $row) use ($getFieldValue, $criterion) {
                    $val = $getFieldValue($row);

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