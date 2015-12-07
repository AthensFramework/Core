<?php

namespace UWDOEM\Framework\Filter;

use Propel\Runtime\ActiveQuery\ModelCriteria;

/**
 * Class DummyFilter Filter class to sit at the end of a chain of filters. Provides no filtering.
 * @package OSFAFramework\Table\Filter
 */
class DummyFilter extends Filter
{
    public function getFeedback()
    {
        return "";
    }

    public function combine(FilterInterface $filter)
    {
        return $filter;
    }

    public function queryFilter(ModelCriteria $query)
    {
        return $query;
    }

    public function rowFilter(array $rows)
    {
        return $rows;
    }

    public function getNextFilter()
    {
        return null;
    }

    public function __construct()
    {
        // Do NOT place a DummyFilter at the end of this DummyFilter
    }
}
