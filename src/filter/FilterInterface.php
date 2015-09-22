<?php

namespace UWDOEM\Framework\Filter;

use Guzzle\Service\Resource\Model;
use Propel\Runtime\ActiveQuery\ModelCriteria;


interface FilterInterface {

    /**
     * @param FilterInterface $filter
     */
    function combine(FilterInterface $filter);

    /**
     * @return string
     */
    function getType();

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