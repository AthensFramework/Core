<?php

namespace UWDOEM\Framework\Filter;

use Guzzle\Service\Resource\Model;
use Propel\Runtime\ActiveQuery\ModelCriteria;

use UWDOEM\Framework\FilterStatement\FilterStatementInterface;
use UWDOEM\Framework\Writer\WritableInterface;

interface FilterInterface extends WritableInterface
{

    /**
     * @param FilterInterface $filter
     */
    public function combine(FilterInterface $filter);

    /**
     * @return string[]
     */
    public function getFeedback();

    /**
     * @return string
     */
    public function getHandle();

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
     * @param \UWDOEM\Framework\Row\Row[] $rows
     * @return \UWDOEM\Framework\Row\Row[]
     */
    public function rowFilter(array $rows);
}
