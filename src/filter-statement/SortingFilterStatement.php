<?php

namespace Athens\Core\FilterStatement;

use Athens\Core\QueryWrapper\QueryWrapperInterface;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Athens\Core\Row\RowInterface;
use Propel\Runtime\ActiveQuery\Criteria;

/**
 * Class SortingFilterStatement
 * @package Athens\Core\FilterStatement
 */
class SortingFilterStatement extends FilterStatement
{

    /**
     * @param QueryWrapperInterface $query
     * @return QueryWrapperInterface
     */
    public function applyToQuery(QueryWrapperInterface $query)
    {
        return $query->orderBy(
            $this->getFieldName(),
            $this->getCondition()
        );
    }

    /**
     * @param RowInterface[] $rows
     * @return RowInterface[]
     */
    public function applyToRows(array $rows)
    {
        $fieldName = $this->getFieldName();
        $cond = $this->getCondition();

        $getFieldValue = function ($row) use ($fieldName) {
            /** @var RowInterface $row */
            return $row->getWritableBearer()->getWritableByHandle($fieldName)->getInitial();
        };

        $comparisonOperator = function ($a, $b) {
            return $a - $b;
        };
        switch ($cond) {
            case static::COND_SORT_ASC:
                // The default $comparisonOperator is fine
                break;

            case static::COND_SORT_DESC:
                $comparisonOperator = function ($a, $b) {
                    return $b - $a;
                };
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
