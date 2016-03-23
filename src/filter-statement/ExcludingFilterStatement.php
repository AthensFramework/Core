<?php

namespace Athens\Core\FilterStatement;

use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\Criteria;

use Athens\Core\Row\RowInterface;

/**
 * Class ExcludingFilterStatement
 *
 * @package Athens\Core\FilterStatement
 */
class ExcludingFilterStatement extends FilterStatement
{

    /**
     * @param ModelCriteria $query
     * @return ModelCriteria
     */
    public function applyToQuery(ModelCriteria $query)
    {
        $fieldName = $this->getFieldName();
        $criterion = $this->getCriterion();

        $objectName = strtok($fieldName, '.');

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

        if ($objectName === $query->getTableMap()->getPhpName()) {
            return $query->{"filterBy" . $fieldName}($criterion, $criteria);
        } else {
            return $query->{"use{$objectName}Query"}()->{"filterBy" . $fieldName}($criterion, $criteria)->endUse();
        }
    }

    /**
     * @param RowInterface[] $rows
     * @return RowInterface[]
     */
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
