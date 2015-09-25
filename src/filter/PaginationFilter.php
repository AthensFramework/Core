<?php

namespace UWDOEM\Framework\Filter;

use Propel\Runtime\ActiveQuery\ModelCriteria;


class PaginationFilter extends Filter {

    protected function getMaxPerPage() {
        return $this->getStatements()[0]->getCriterion();
    }

    protected function getMaxPagesByQuery(ModelCriteria $query) {
        $maxPerPage = $this->getMaxPerPage();
        $totalRows = $query->count();

        return ceil($totalRows / $maxPerPage);
    }

    protected function setOptionsByQuery(ModelCriteria $query) {
        $maxPages = $this->getMaxPagesByQuery($query);
        $this->_options = range(1, $maxPages);
    }

    protected function setFeedbackByQuery(ModelCriteria $query) {

        $page = $this->getStatements()[0]->getControl();
        $maxPerPage = $this->getMaxPerPage();

        $totalRows = $query->count();

        $firstRow = $page*$maxPerPage + 1;
        $lastRow = $firstRow + $maxPerPage;


        $this->_feedback = "Displaying results $firstRow-$lastRow of $totalRows.";
    }

}