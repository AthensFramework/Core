<?php

namespace UWDOEM\Framework\Filter;

use Propel\Runtime\ActiveQuery\ModelCriteria;

use UWDOEM\Framework\Etc\ORMUtils;
use UWDOEM\Framework\Row\RowInterface;
use UWDOEM\Framework\Visitor\VisitableTrait;
use UWDOEM\Framework\FilterStatement\FilterStatementInterface;
use UWDOEM\Framework\Writer\WritableTrait;

/**
 * Class Filter
 *
 * @package UWDOEM\Framework\Filter
 */
class Filter implements FilterInterface
{

    const TYPE_SEARCH = "search";
    const TYPE_SORT = "sort";
    const TYPE_SELECT = "select";
    const TYPE_STATIC = "static";
    const TYPE_PAGINATION = "pagination";

    /** @var FilterStatementInterface[] */
    protected $statements = [];

    /** @var FilterStatementInterface[] */
    protected $queryStatements = [];

    /** @var array */
    protected $options = [];

    /** @var string */
    protected $feedback;
    
    /** @var boolean */
    protected $canQueryFilter;

    /**
     * @var FilterInterface The next filter in this chain
     */
    protected $nextFilter;

    use VisitableTrait;
    use WritableTrait;

    /**
     * @param string                     $id
     * @param string[]                   $classes
     * @param FilterStatementInterface[] $statements
     * @param FilterInterface|null       $nextFilter
     */
    public function __construct($id, array $classes, array $statements, FilterInterface $nextFilter = null)
    {

        if ($nextFilter === null) {
            $this->nextFilter = new DummyFilter();
        } else {
            $this->nextFilter = $nextFilter;
        }

        $this->id = $id;
        $this->statements = $statements;
        $this->classes = $classes;
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
     * @return FilterInterface
     */
    public function getNextFilter()
    {
        return $this->nextFilter;
    }

    /**
     * @return FilterStatementInterface[]
     */
    public function getStatements()
    {
        return $this->statements;
    }

    /**
     * @return FilterStatementInterface[]
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

        $this->canQueryFilter = true;

        if ($this->getNextFilter()->canQueryFilter === false) {
            $this->canQueryFilter = false;
        }

        foreach ($this->statements as $statement) {

            $fieldName = $statement->getFieldName();

            if ($fieldName !== "" && ORMUtils::queryContainsFieldName($query, $fieldName) === false) {
                $this->canQueryFilter = false;
            }

            if ($this->canQueryFilter === true) {
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
     * @return void
     */
    protected function setOptionsByQuery(ModelCriteria $query)
    {
    }

    /**
     * @param ModelCriteria $query
     * @return void
     */
    protected function setFeedbackByQuery(ModelCriteria $query)
    {
    }

    /**
     * @param RowInterface[] $rows
     * @return void
     */
    protected function setOptionsByRows(array $rows)
    {
    }

    /**
     * @param RowInterface[] $rows
     * @return void
     */
    protected function setFeedbackByRows(array $rows)
    {
    }

    /**
     * @param RowInterface[] $rows
     * @return RowInterface[]
     */
    public function rowFilter(array $rows)
    {
        $this->setOptionsByRows($rows);
        $this->setFeedbackByRows($rows);

        $rows = $this->getNextFilter()->rowFilter($rows);
        foreach ($this->getRowStatements() as $statement) {
            $rows = $statement->applyToRows($rows);
        }

        return $rows;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }
}
