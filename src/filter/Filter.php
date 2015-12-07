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
    protected $statements = [];

    /** @var array|FilterStatementInterface[] */
    protected $queryStatements = [];

    /** @var string */
    protected $handle;

    /** @var array */
    protected $options = [];

    /** @var string */
    protected $feedback;

    /**
     * @var FilterInterface The next filter in this chain
     */
    protected $nextFilter;

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
            $this->nextFilter = new DummyFilter();
        } else {
            $this->nextFilter = $nextFilter;
        }

        $this->handle = $handle;
        $this->statements = $statements;
    }

    /**
     * @return string[]
     */
    public function getFeedback()
    {
        return $this->feedback;
    }

    /**
     * @param FilterInterface $filter
     * @return FilterInterface
     */
    public function combine(FilterInterface $filter)
    {
        $this->nextFilter = $filter;
        return $this;
    }

    /**
     * @return string
     */
    public function getHandle()
    {
        return $this->handle;
    }

    /**
     * @return null|FilterInterface
     */
    public function getNextFilter()
    {
        return $this->nextFilter;
    }

    /**
     * @return FilterStatement[]
     */
    public function getStatements()
    {
        return $this->statements;
    }

    /**
     * @return FilterStatement[]
     */
    protected function getRowStatements()
    {
        $queryStatements = $this->queryStatements;
        return array_filter(
            $this->statements,
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

        foreach ($this->statements as $statement) {

            $fieldName = $statement->getFieldName();
            if ($fieldName && !ORMUtils::queryContainsFieldName($query, $fieldName)) {
                $queryFilterBroken = true;
            }

            if ($queryFilterBroken === false) {
                $this->setOptionsByQuery($query);
                $this->setFeedbackByQuery($query);
                $query = $statement->applyToQuery($query);

                $this->queryStatements[] = $statement;
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
        return $this->options;
    }
}
