<?php

namespace Athens\Core\Filter;

use Propel\Runtime\ActiveQuery\ModelCriteria;

use Athens\Core\FilterStatement\PaginationFilterStatement;
use Athens\Core\FilterStatement\FilterStatement;
use Athens\Core\Row\RowInterface;

/**
 * Class PaginationFilter
 *
 * @package Athens\Core\Filter
 */
class PaginationFilter extends Filter
{

    const TYPE_HARD_PAGINATION = "hard";
    const TYPE_SOFT_PAGINATION = "soft";

    /** @var string */
    protected $type;

    /** @var integer */
    protected $numPages;

    /** @var integer */
    protected $page;

    /**
     * @param string               $id
     * @param string[]             $classes
     * @param integer              $maxPerPage
     * @param integer              $page
     * @param FilterInterface|null $nextFilter
     */
    public function __construct($id, array $classes, $maxPerPage, $page, FilterInterface $nextFilter = null)
    {
        $statements = [new PaginationFilterStatement("", FilterStatement::COND_PAGINATE_BY, $maxPerPage, $page)];

        parent::__construct($id, $classes, $statements, $nextFilter);
    }

    /**
     * @return integer
     */
    protected function getMaxPerPage()
    {
        return $this->getStatements()[0]->getCriterion();
    }

    /**
     * @param ModelCriteria $query
     * @return integer
     */
    protected function getMaxPagesByQuery(ModelCriteria $query)
    {
        $maxPerPage = $this->getMaxPerPage();
        $totalRows = $query->count();

        return ceil($totalRows / $maxPerPage);
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return integer
     */
    public function getNumPages()
    {
        return $this->numPages;
    }

    /**
     * @return integer
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param ModelCriteria $query
     * @return void
     */
    protected function setOptionsByQuery(ModelCriteria $query)
    {
        $maxPages = max($this->getMaxPagesByQuery($query), 1);
        $this->options = range(1, $maxPages);

        $this->type = static::TYPE_HARD_PAGINATION;
    }

    /**
     * @param ModelCriteria $query
     * @return void
     */
    protected function setFeedbackByQuery(ModelCriteria $query)
    {
        $page = $this->getStatements()[0]->getControl();
        $maxPerPage = $this->getMaxPerPage();

        $totalRows = $query->count();

        $firstRow = min($totalRows, ($page - 1)*$maxPerPage + 1);
        $lastRow = min($firstRow + $maxPerPage - 1, $query->count());

        $this->feedback = "Displaying results $firstRow-$lastRow of $totalRows.";

        $this->page = $page;
        $this->numPages = $this->getMaxPagesByQuery($query);
    }

    /**
     * @param RowInterface[] $rows
     * @return void
     */
    protected function setOptionsByRows(array $rows)
    {
        if ($this->getRowStatements() !== []) {
            $this->type = static::TYPE_SOFT_PAGINATION;
        }
    }
}
