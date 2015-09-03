<?php

namespace UWDOEM\Framework\Filter;

use UWDOEM\Framework\Row\RowInterface;
use Propel\Runtime\ActiveQuery\PropelQuery;


interface FilterInterface {

    /**
     * @param FilterInterface $filter
     */
    function combine(FilterInterface $filter);

    /**
     * @return string[]
     */
    function getFeedback();

    /**
     * @param array $filterArgs
     * @param RowInterface[] $rows
     * @return RowInterface[]
     */
    function rowFilter(array $filterArgs, array $rows);

    /**
     * @param array $filterArgs
     * @param PropelQuery $query
     * @return PropelQuery
     */
    function queryFilter(array $filterArgs, PropelQuery $query);

    /**
     * Returns True if this filter/set of filters has encrypted fields, false otherwise
     * @return Boolean
     */
    function hasEncryptedFields();

}