<?php

namespace Athens\Core\Filter;

use Guzzle\Service\Resource\Model;
use Propel\Runtime\ActiveQuery\ModelCriteria;

use Athens\Core\FilterStatement\FilterStatementInterface;
use Athens\Core\Writer\WritableInterface;

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
     * @param ModelCriteria $query
     * @return ModelCriteria
     */
    public function queryFilter(ModelCriteria $query);

    /**
     * @param \Athens\Core\Row\Row[] $rows
     * @return \Athens\Core\Row\Row[]
     */
    public function rowFilter(array $rows);
}
