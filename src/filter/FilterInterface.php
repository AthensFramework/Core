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
    function combine(FilterInterface $filter);

    /**
     * @return string[]
     */
    function getFeedback();

    /**
     * @return string
     */
    function getHandle();

    /**
     * @return FilterInterface
     */
    function getNextFilter();

    /**
     * @return FilterStatementInterface[]
     */
    function getStatements();

    /**
     * @return array
     */
    function getOptions();

    /**
     * @param ModelCriteria $query
     * @return ModelCriteria
     */
    function queryFilter(ModelCriteria $query);

    /**
     * @param \UWDOEM\Framework\Row\Row[] $rows
     * @return \UWDOEM\Framework\Row\Row[]
     */
    function rowFilter(array $rows);
}
