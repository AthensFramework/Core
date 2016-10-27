<?php

namespace Athens\Core\FilterStatement;

use Athens\Core\ORMWrapper\QueryWrapperInterface;

use Athens\Core\Row\RowInterface;
use Athens\Core\Settings\Settings;
use Athens\Core\Writer\HTMLWriter;

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
        return $query->filterBy($this->fieldName, $this->criterion, $this->condition);
    }

    /**
     * @param QueryWrapperInterface $query
     * @return boolean
     */
    public function canApplyToQuery(QueryWrapperInterface $query)
    {
        return $query->canFilterBy($this->fieldName, $this->criterion, $this->condition);
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

        $writer = new HTMLWriter();  // TODO: Abstract out HTMLWriter

        $getFieldValue = function (RowInterface $row) use ($fieldName, $writer) {
            $cell = $row->getWritableBearer()->getWritableByHandle($fieldName);

            return trim(strip_tags($cell->accept($writer)));
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
