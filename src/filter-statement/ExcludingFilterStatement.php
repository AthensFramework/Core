<?php

namespace UWDOEM\Framework\FilterStatement;

use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\Criteria;
use UWDOEM\Framework\Row\RowInterface;

use Workstudy\Map\JobInformationTableMap;

class ExcludingFilterStatement extends FilterStatement
{

    public function applyToQuery(ModelCriteria $query)
    {
        $fieldName = $this->getFieldName();
        $criterion = $this->getCriterion();

        if (($pos = strpos($fieldName, ".")) !== false) {
            $fieldName = substr($fieldName, $pos+1);
        }

        $criteria = Criteria::LIKE;

        switch ($this->getCondition()) {
            case static::COND_LESS_THAN:
                $criteria = Criteria::LESS_THAN;
                break;

            case static::COND_GREATER_THAN:
                $criteria = Criteria::GREATER_THAN;
                break;

            case static::COND_EQUAL_TO:
                $criteria = Criteria::EQUAL;
                break;

            case static::COND_NOT_EQUAL_TO:
                $criteria = Criteria::NOT_EQUAL;
                break;

            case static::COND_CONTAINS:
                $criterion = "%$criterion%";
                $criteria = Criteria::LIKE;
                break;
        }

        return $query->{"filterBy" . $fieldName}($criterion, $criteria);
    }

    public function applyToRows(array $rows)
    {
        $fieldName = $this->getFieldName();
        $condition = $this->getCondition();
        $criterion = $this->getCriterion();

        $getFieldValue = function ($row) use ($fieldName) {
            /** @var RowInterface $row */
            return $row->getFieldBearer()->getFieldByName($fieldName)->getInitial();
        };

        $filterFunction = function ($val) use ($criterion) {
            return true;

        };

        switch ($condition) {
            case static::COND_LESS_THAN:
                $filterFunction = function ($val) use ($criterion) {
                    return $val < $criterion;

                };
                break;

            case static::COND_GREATER_THAN:
                $filterFunction = function ($val) use ($criterion) {
                    return $val > $criterion;

                };
                break;

            case static::COND_EQUAL_TO:
                $filterFunction = function ($val) use ($criterion) {
                    return $val === $criterion;

                };
                break;

            case static::COND_NOT_EQUAL_TO:
                $filterFunction = function ($val) use ($criterion) {
                    return $val !== $criterion;

                };
                break;

            case static::COND_CONTAINS:
                $filterFunction = function ($val) use ($criterion) {
                    return strripos($val, $criterion) !== false;

                };
                break;
        }

        $filter = function (RowInterface $row) use ($getFieldValue, $filterFunction) {
            $val = $getFieldValue($row);
            return $filterFunction($val);
        };

        return array_filter($rows, $filter);
    }
}
