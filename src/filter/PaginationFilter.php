<?php

namespace UWDOEM\Framework\Filter;

use Propel\Runtime\ActiveQuery\ModelCriteria;

use UWDOEM\Framework\Etc\Settings;
use UWDOEM\Framework\FilterStatement\PaginationFilterStatement;
use UWDOEM\Framework\FilterStatement\FilterStatement;

class PaginationFilter extends Filter
{

    const TYPE_HARD_PAGINATION = "hard";
    const TYPE_SOFT_PAGINATION = "soft";

    protected $type;
    protected $numPages;
    protected $page;


    public function __construct($handle, $maxPerPage, $page, FilterInterface $nextFilter = null)
    {
        $statements = [new PaginationFilterStatement(null, FilterStatement::COND_PAGINATE_BY, $maxPerPage, $page)];

        parent::__construct($handle, $statements, $nextFilter);
    }

    protected function getMaxPerPage()
    {
        return $this->getStatements()[0]->getCriterion();
    }

    protected function getMaxPagesByQuery(ModelCriteria $query)
    {
        $maxPerPage = $this->getMaxPerPage();
        $totalRows = $query->count();

        return ceil($totalRows / $maxPerPage);
    }

    public function getType()
    {
        return $this->type;
    }

    public function getNumPages()
    {
        return $this->numPages;
    }

    public function getPage()
    {
        return $this->page;
    }

    protected function setOptionsByQuery(ModelCriteria $query)
    {
        $maxPages = max($this->getMaxPagesByQuery($query), 1);
        $this->options = range(1, $maxPages);
    }

    protected function setFeedbackByQuery(ModelCriteria $query)
    {

        $page = $this->getStatements()[0]->getControl();
        $maxPerPage = $this->getMaxPerPage();

        $totalRows = $query->count();

        $firstRow = min($totalRows, ($page - 1)*$maxPerPage + 1);
        $lastRow = min($firstRow + $maxPerPage - 1, $query->count());

        $this->feedback = "Displaying results $firstRow-$lastRow of $totalRows.";

        $this->type = static::TYPE_HARD_PAGINATION;
        $this->page = $page;
        $this->numPages = $this->getMaxPagesByQuery($query);
    }
}
