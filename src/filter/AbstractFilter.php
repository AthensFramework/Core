<?php

namespace UWDOEM\Framework\Filter;

use Propel\Runtime\ActiveQuery\PropelQuery;
use UWDOEM\Framework\Row\RowInterface;


abstract class AbstractFilter implements FilterInterface {

    protected $_feedback;

    protected $_controls;

    /**
     * @var Boolean Whether or not this filter operated on encrypted fields
     */
    protected $_encryptedFields;

    /**
     * @var FilterInterface The next filter in this chain
     */
    protected $_nextFilter;

    /**
     * Filter rows for this row only.
     *
     * @param array $filterArgs
     * @param RowInterface[] $rows
     * @return RowInterface[]
     */
    abstract protected function doRowFilter(array $filterArgs, array $rows);

    /**
     * Provide a query filter for this query only
     *
     * @param array $filterArgs
     * @param PropelQuery $query
     * @return PropelQuery
     */
    abstract protected function doQueryFilter(array $filterArgs, PropelQuery $query);

    /**
     * Place a dummy filter on the end of this filter chain, if no filter exists
     */
    public function __construct() {
        if (is_null($this->_nextFilter)) {
            $this->_nextFilter = new DummyFilter();
        }
    }

    /**
     * @param array $filterArgs
     * @param RowInterface[] $rows
     * @return RowInterface[]
     */
    public final function rowFilter(array $filterArgs, array $rows) {
        $rows = $this->_nextFilter->rowFilter($filterArgs, $rows);
        return $this->doRowFilter($filterArgs, $this->_nextFilter->rowFilter($filterArgs, $rows));
    }

    /**
     * @param array $filterArgs
     * @param PropelQuery $query
     * @return PropelQuery
     */
    public final function queryFilter(array $filterArgs, PropelQuery $query) {
        $query = $this->_nextFilter->queryFilter($filterArgs, $query);
        return $this->doQueryFilter($filterArgs, $this->_nextFilter->queryFilter($filterArgs, $query));
    }

    /**
     * @return bool
     */
    public function hasEncryptedFields() {
        return $this->_encryptedFields;
    }

    /**
     * @param FilterInterface $filter
     * @return FilterInterface
     */
    public function combine(FilterInterface $filter) {
        $this->_nextFilter = $filter;
        $this->_encryptedFields |= $filter->hasEncryptedFields();
        return $this;
    }

    /**
     * @return string[]
     */
    public function getFeedback() {
        $feedback = array_merge($this->getFeedback(), $this->_nextFilter->getFeedback());

        return array_merge([$this->_feedback], $feedback);
    }



}

/**
 * Class DummyFilter Filter class to sit at the end of a chain of filters. Provides no filtering.
 * @package OSFAFramework\Table\Filter
 */
class DummyFilter extends AbstractFilter {
    function getFeedback() {
        return [];
    }

    function combine(FilterInterface $filter) {
        return $filter;
    }

    function doRowFilter(array $filterArgs, array $rows) {
        return $rows;
    }

    function doQueryFilter(array $filterArgs, PropelQuery $query) {
        return $query;
    }

    function hasEncryptedFields() {
        return false;
    }

    public function __construct() {
        // Do NOT place a DummyFilter at the end of this DummyFilter
    }
}