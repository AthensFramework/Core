<?php

namespace Athens\Core\FilterStatement;

use Athens\Core\ORMWrapper\QueryWrapperInterface;

use Athens\Core\Row\RowInterface;

/**
 * Class ExcludingFilterStatement
 *
 * @package Athens\Core\FilterStatement
 */
class ExcludingFilterStatement extends FilterStatement
{

    /**
     * @param QueryWrapperInterface $query
     * @return QueryWrapperInterface
     */
    public function applyToQuery(QueryWrapperInterface $query)
    {
        return $query->filterBy($this->fieldName, $this->condition, $this->criterion);
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
            return $row->getWritableBearer()->getWritableByHandle($fieldName)->getInitial();
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

            case static::COND_ALL:
                $filterFunction = function ($val) use ($criterion) {
                    return true;
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
