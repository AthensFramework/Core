<?php

namespace Athens\Core\Filter;

use Athens\Core\FilterStatement\FilterStatementInterface;
use Athens\Core\ORMWrapper\QueryWrapperInterface;
use Athens\Core\Writable\WritableInterface;

interface FilterInterface extends WritableInterface
{

    /**
     * @param FilterInterface $filter
     * @return void
     */
    public function combine(FilterInterface $filter);

    /**
     * @return string[]
     */
    public function getFeedback();

    /**
     * @return FilterInterface
     */
    public function getNextFilter();

    /**
     * @return FilterStatementInterface[]
     */
    public function getStatements();

    /**
     * @return array
     */
    public function getOptions();

    /**
     * @param QueryWrapperInterface $query
     * @return QueryWrapperInterface
     */
    public function queryFilter(QueryWrapperInterface $query);

    /**
     * @param \Athens\Core\Row\Row[] $rows
     * @return \Athens\Core\Row\Row[]
     */
    public function rowFilter(array $rows);
}
