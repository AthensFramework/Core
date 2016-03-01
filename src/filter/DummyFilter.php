<?php

namespace Athens\Core\Filter;

use Propel\Runtime\ActiveQuery\ModelCriteria;
use Athens\Core\Row\RowInterface;

/**
 * Class DummyFilter Filter class to sit at the end of a chain of filters. Provides no filtering.
 * @package OSFAFramework\Table\Filter
 */
class DummyFilter extends Filter
{

    /**
     * @return string
     */
    public function getFeedback()
    {
        return "";
    }

    /**
     * @param FilterInterface $filter
     * @return FilterInterface
     */
    public function combine(FilterInterface $filter)
    {
        return $filter;
    }

    /**
     * @param ModelCriteria $query
     * @return ModelCriteria
     */
    public function queryFilter(ModelCriteria $query)
    {
        return $query;
    }

    /**
     * @param RowInterface[] $rows
     * @return RowInterface[]
     */
    public function rowFilter(array $rows)
    {
        return $rows;
    }

    /**
     * @return null
     */
    public function getNextFilter()
    {
        return null;
    }

    /**
     * Do NOT place a DummyFilter at the end of this DummyFilter
     */
    public function __construct()
    {
    }
}
