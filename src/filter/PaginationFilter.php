<?php

namespace UWDOEM\Framework\Filter;

use Propel\Runtime\ActiveQuery\ModelCriteria;


class PaginationFilter extends Filter {

    const TYPE_HARD_PAGINATION = "hard";
    const TYPE_SOFT_PAGINATION = "soft";

    protected $_type;
    protected $_numPages;
    protected $_page;

    protected function getMaxPerPage() {
        return $this->getStatements()[0]->getCriterion();
    }

    protected function getMaxPagesByQuery(ModelCriteria $query) {
        $maxPerPage = $this->getMaxPerPage();
        $totalRows = $query->count();

        return ceil($totalRows / $maxPerPage);
    }

    public function getType() {
        return $this->_type;
    }

    public function getNumPages() {
        return $this->_numPages;
    }

    public function getPage() {
        return $this->_page;
    }

    protected function setOptionsByQuery(ModelCriteria $query) {
        $maxPages = $this->getMaxPagesByQuery($query);
        $this->_options = range(1, $maxPages);
    }

    protected function setFeedbackByQuery(ModelCriteria $query) {

        $page = $this->getStatements()[0]->getControl();
        $maxPerPage = $this->getMaxPerPage();

        $totalRows = $query->count();

        $firstRow = ($page - 1)*$maxPerPage + 1;
        $lastRow = min($firstRow + $maxPerPage - 1, $query->count());

        $this->_feedback = "Displaying results $firstRow-$lastRow of $totalRows.";

        $this->_type = static::TYPE_HARD_PAGINATION;
        $this->_page = $page;
        $this->_numPages = $this->getMaxPagesByQuery($query);
    }

}