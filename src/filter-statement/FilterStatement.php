<?php

namespace Athens\Core\FilterStatement;

use Athens\Core\ORMWrapper\QueryWrapperInterface;
use Athens\Core\Row\RowInterface;

/**
 * Class FilterStatement
 *
 * @package Athens\Core\FilterStatement
 */
abstract class FilterStatement implements FilterStatementInterface
{

    /** @var string */
    protected $fieldName;

    /** @var string */
    protected $condition;

    /** @var mixed */
    protected $criterion;

    /** @var mixed */
    protected $control;

    /**
     * FilterStatement constructor.
     *
     * @param string $fieldName
     * @param string $condition
     * @param mixed  $criterion
     * @param mixed  $control
     */
    public function __construct($fieldName, $condition, $criterion, $control)
    {
        $this->fieldName = $fieldName;
        $this->condition = $condition;
        $this->criterion = $criterion;
        $this->control = $control;
    }

    /**
     * @return string
     */
    public function getFieldName()
    {
        return $this->fieldName;
    }

    /**
     * @return string
     */
    public function getCondition()
    {
        return $this->condition;
    }

    /**
     * @return mixed
     */
    public function getCriterion()
    {
        return $this->criterion;
    }

    /**
     * @return mixed
     */
    public function getControl()
    {
        return $this->control;
    }

    /**
     * @param QueryWrapperInterface $query
     * @return QueryWrapperInterface
     */
    abstract public function applyToQuery(QueryWrapperInterface $query);

    /**
     * @param QueryWrapperInterface $query
     * @return boolean
     */
    abstract public function canApplyToQuery(QueryWrapperInterface $query);

    /**
     * @param RowInterface[] $rows
     * @return RowInterface[]
     */
    abstract public function applyToRows(array $rows);
}
