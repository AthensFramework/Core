<?php

namespace UWDOEM\Framework\FilterStatement;

use Propel\Runtime\ActiveQuery\ModelCriteria;
use UWDOEM\Framework\Row\RowInterface;
use Propel\Runtime\ActiveQuery\Criteria;


class SortingFilterStatement extends FilterStatement {

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
        }

        return $query;
    }


    public function applyToRows(array $rows) {
        $fieldName = $this->getFieldName();
        $cond = $this->getCondition();

        $getFieldValue = function ($row) use ($fieldName) {
            /** @var RowInterface $row */
            return $row->getFieldBearer()->getFieldByName($fieldName)->getInitial();
        };

        $comparisonOperator = function ($a, $b) { return $a - $b; };
        switch ($cond) {
            case static::COND_SORT_ASC:
                // The default $comparisonOperator is fine
                break;

            case static::COND_SORT_DESC:
                $comparisonOperator = function ($a, $b) { return $b - $a; };
                break;
        }

        $compare = function (RowInterface $a, RowInterface $b) use ($getFieldValue, $comparisonOperator) {
            $valA = $getFieldValue($a);
            $valB = $getFieldValue($b);

            return $comparisonOperator($valA, $valB);
        };

        uasort($rows, $compare);

        return $rows;
    }

}