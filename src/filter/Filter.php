<?php

namespace UWDOEM\Framework\Filter;

use Propel\Runtime\ActiveQuery\ModelCriteria;

use UWDOEM\Framework\Etc\ORMUtils;
use UWDOEM\Framework\Row\RowInterface;


class Filter implements FilterInterface {

    const TYPE_SEARCH = "search";
    const TYPE_SORT = "sort";
    const TYPE_SELECT = "select";
    const TYPE_STATIC = "static";
    const TYPE_PAGINATION = "pagination";

    protected $_type;

    /** @var array|FilterStatementInterface[] */
    protected $_statements = [];

    /** @var array|FilterStatementInterface[] */
    protected $_queryStatements = [];

    /** @var array|FilterStatementInterface[] */
    protected $_rowStatements = [];

    /** @var string */
    protected $_handle;

    /** @var array */
    protected $_options;

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

        if (is_null($nextFilter)) {
            $this->_nextFilter = new DummyFilter();
        } else {
            $this->_nextFilter = $nextFilter;
        }

        $this->_handle = $handle;
        $this->_statements = $statements;
        $this->_type = $type;
    }

    /**
     * @return string[]
     */
    public function getFeedback() {
        return array_merge([$this->makeFeedback()], $this->_nextFilter->getFeedback());
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

    /**
     * @param ModelCriteria $query
     * @return ModelCriteria
     */
    public function queryFilter(ModelCriteria $query) {
        $query = $this->getNextFilter()->queryFilter($query);

        $queryFilterBroken = false;

        if ($this->getNextFilter()->_rowStatements) {
            $this->_rowStatements = $this->_statements;
            $queryFilterBroken = true;
        }

        foreach ($this->_statements as $statement) {

            $fieldName = $statement->getFieldName();
            if ($fieldName && !ORMUtils::queryContainsFieldName($query, $fieldName)) {
                $queryFilterBroken = true;
            }

            if ($queryFilterBroken === true) {
                $this->_rowStatements[] = $statement;
            } else {
                $this->setOptionsByQuery($query);
                $query = $statement->applyToQuery($query);
            }
        }
        return $query;
    }

    /**
     * @param ModelCriteria $query
     */
    protected function setOptionsByQuery($query) {
        switch ($this->getType()) {
            case static::TYPE_PAGINATION:
                $maxPerPage = $this->getStatements()[0]->getCriterion();
                $totalRows = $query->count();
                $numPages = ceil($totalRows/$maxPerPage);
                $this->_options = range(1,$numPages);
                break;
        }
    }

    /**
     * @param RowInterface[] $rows
     * @return RowInterface[]
     */
    public function rowFilter(array $rows) {
        $rows = $this->getNextFilter()->rowFilter($rows);

        foreach ($this->_rowStatements as $statement) {
            $rows = $statement->applyToRows($rows);
        }

        return $rows;
    }

    public function getOptions() {
        return $this->_options;
    }

    protected function makeFeedback() {

        $feedback = "";
        switch ($this->getType()) {
            case static::TYPE_STATIC:
                break;
            case static::TYPE_PAGINATION:
                $feedback = "Pagination feedback.";
                break;
        }

        return $feedback;
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

    function queryFilter(ModelCriteria $query) {
        return $query;
    }

    function rowFilter(array $rows) {
        return $rows;
    }

    function getNextFilter() {
        return null;
    }

    public function __construct() {
        // Do NOT place a DummyFilter at the end of this DummyFilter
    }
}