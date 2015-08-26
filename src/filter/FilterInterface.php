<?php
/**
 * Created by PhpStorm.
 * User: jschilz
 * Date: 8/24/2015
 * Time: 7:51 AM
 */

namespace OSFAFramework\Table\Filter;

use OSFAFramework\Table\Row\RowInterface;
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