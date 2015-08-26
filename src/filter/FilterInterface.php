<?php

namespace OSFAFramework\Table\Filter;

use UWDOEM\Framework\Row\RowInterface;
use Propel\Runtime\ActiveQuery\PropelQuery;


interface FilterInterface {

    /**
     * @return string[]
     */
    function getFeedback();

    /**
     * Combine two filters into one.
     *
     * @param FilterInterface $filter
     * @return FilterInterface
     */
    function combine(FilterInterface $filter);

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