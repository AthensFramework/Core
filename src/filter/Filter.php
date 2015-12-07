<?php

namespace UWDOEM\Framework\Filter;

use Propel\Runtime\ActiveQuery\ModelCriteria;

use UWDOEM\Framework\Etc\ORMUtils;
use UWDOEM\Framework\Row\RowInterface;
use UWDOEM\Framework\FilterStatement\FilterStatementInterface;
use UWDOEM\Framework\Visitor\VisitableTrait;

class Filter implements FilterInterface
{

    const TYPE_SEARCH = "search";
    const TYPE_SORT = "sort";
    const TYPE_SELECT = "select";
    const TYPE_STATIC = "static";
    const TYPE_PAGINATION = "pagination";

    /** @var array|FilterStatementInterface[] */
    protected $_statements = [];

    /** @var array|FilterStatementInterface[] */
    protected $_queryStatements = [];

    /** @var string */
    protected $_handle;

    /** @var array */
    protected $_options = [];

    /** @var string */
    protected $_feedback;

    /**
     * @var FilterInterface The next filter in this chain
     */
    protected $_nextFilter;

    use VisitableTrait;


    public function getId()
    {
        return md5($this->getHandle());
    }

    /**
     * @param $handle
     * @param FilterStatementInterface[] $statements
     * @param FilterInterface|null $nextFilter
     */
    public function __construct($handle, array $statements, FilterInterface $nextFilter = null)
    {

        if (is_null($nextFilter)) {
            $this->_nextFilter = new DummyFilter();
        } else {
            $this->_nextFilter = $nextFilter;
        }

        $this->_handle = $handle;
        $this->_statements = $statements;
    }

    /**
     * @return string[]
     */
    public function getFeedback()
    {
        return $this->_feedback;
    }

    /**
     * @param FilterInterface $filter
     * @return FilterInterface
     */
    public function combine(FilterInterface $filter)
    {
        $this->_nextFilter = $filter;
        return $this;
    }

    /**
     * @return string
     */
    public function getHandle()
    {
        return $this->_handle;
    }

    /**
     * @return null|FilterInterface
     */
    function getNextFilter()
    {
        return $this->_nextFilter;
    }

    /**
     * @return FilterStatement[]
     */
    public function getStatements()
    {
        return $this->_statements;
    }

    /**
     * @return FilterStatement[]
     */
    protected function getRowStatements()
    {
        $queryStatements = $this->_queryStatements;
        return array_filter(
            $this->_statements,
            function ($statement) use ($queryStatements) {
                return array_search($statement, $queryStatements) === false;
            }
        );
    }

    /**
     * @param ModelCriteria $query
     * @return ModelCriteria
     */
    public function queryFilter(ModelCriteria $query)
    {
        $query = $this->getNextFilter()->queryFilter($query);

        $queryFilterBroken = false;

        if ($this->getNextFilter()->getRowStatements()) {
            $queryFilterBroken = true;
        }

        foreach ($this->_statements as $statement) {

            $fieldName = $statement->getFieldName();
            if ($fieldName && !ORMUtils::queryContainsFieldName($query, $fieldName)) {
                $queryFilterBroken = true;
            }

            if ($queryFilterBroken === false) {
                $this->setOptionsByQuery($query);
                $this->setFeedbackByQuery($query);
                $query = $statement->applyToQuery($query);

                $this->_queryStatements[] = $statement;
            }
        }
        return $query;
    }

    /**
     * @param ModelCriteria $query
     */
    protected function setOptionsByQuery(ModelCriteria $query)
    {
    }

    /**
     * @param ModelCriteria $query
     */
    protected function setFeedbackByQuery(ModelCriteria $query)
    {
    }

    /**
     * @param RowInterface[] $rows
     */
    protected function setOptionsByRows(array $rows)
    {
    }

    /**
     * @param RowInterface[] $rows
     * @return RowInterface[]
     */
    public function rowFilter(array $rows)
    {
        $this->setOptionsByRows($rows);

        $rows = $this->getNextFilter()->rowFilter($rows);
        foreach ($this->getRowStatements() as $statement) {
            $rows = $statement->applyToRows($rows);
        }

        return $rows;
    }

    public function getOptions()
    {
        return $this->_options;
    }
}


/**
 * Class DummyFilter Filter class to sit at the end of a chain of filters. Provides no filtering.
 * @package OSFAFramework\Table\Filter
 */
class DummyFilter extends Filter
{
    function getFeedback()
    {
        return "";
    }

    function combine(FilterInterface $filter)
    {
        return $filter;
    }

    function queryFilter(ModelCriteria $query)
    {
        return $query;
    }

    function rowFilter(array $rows)
    {
        return $rows;
    }

    function getNextFilter()
    {
        return null;
    }

    public function __construct()
    {
        // Do NOT place a DummyFilter at the end of this DummyFilter
    }
}
