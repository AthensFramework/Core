<?php

namespace UWDOEM\Framework\Filter;

use Propel\Runtime\ActiveQuery\PropelQuery;
use UWDOEM\Framework\Row\RowInterface;


class Filter implements FilterInterface {

    const TYPE_SEARCH = "search";
    const TYPE_SORT = "sort";
    const TYPE_SELECT = "select";
    const TYPE_STATIC = "static";
    const TYPE_PAGINATION = "pagination";

    protected $_type;
    protected $_feedback;
    protected $_statements;
    protected $_handle;

    /**
     * @var FilterInterface The next filter in this chain
     */
    protected $_nextFilter;

    /**
     * @param $handle
     * @param $type
     * @param FilterStatementInterface[] $statements
     * @param FilterInterface|null $nextFilter
     */
    public function __construct($handle, $type, array $statements, FilterInterface $nextFilter = null) {
        $this->_statements = $statements;

        if (is_null($nextFilter)) {
            $this->_nextFilter = new DummyFilter();
        } else {
            $this->_nextFilter = $nextFilter;
        }
        $this->_handle = $handle;
    }

    /**
     * @return string[]
     */
    public function getFeedback() {
        $feedback = array_merge($this->getFeedback(), $this->_nextFilter->getFeedback());

        return array_merge([$this->_feedback], $feedback);
    }

    /**
     * @return string
     */
    public function getType() {
        return $this->_type;
    }

    /**
     * @param FilterInterface $filter
     * @return FilterInterface
     */
    public function combine(FilterInterface $filter) {
        $this->_nextFilter = $filter;
        return $this;
    }

    /**
     * @return string
     */
    public function getHandle() {
        return $this->_handle;
    }

    /**
     * @return null|FilterInterface
     */
    function getNextFilter() {
        return $this->_nextFilter;
    }

    /**
     * @return FilterStatement[]
     */
    public function getStatements() {
        return $this->_statements;
    }





}

/**
 * Class DummyFilter Filter class to sit at the end of a chain of filters. Provides no filtering.
 * @package OSFAFramework\Table\Filter
 */
class DummyFilter extends Filter {
    function getFeedback() {
        return [];
    }

    function combine(FilterInterface $filter) {
        return $filter;
    }

    function hasEncryptedFields() {
        return false;
    }

    function getNextFilter() {
        return null;
    }

    public function __construct() {
        // Do NOT place a DummyFilter at the end of this DummyFilter
    }
}