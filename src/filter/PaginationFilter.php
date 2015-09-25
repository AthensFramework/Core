<?php

namespace UWDOEM\Framework\Filter;


class PaginationFilter extends Filter {

    protected function getMaxPerPage() {
        return $this->getStatements()[0]->getCriterion();
    }

    protected function getMaxPagesByQuery($query) {
        $maxPerPage = $this->getMaxPerPage();
        $totalRows = $query->count();

        $numPages = ceil($totalRows / $maxPerPage);
    }

    protected function setOptionsByQuery($query) {
        $page = $this->getStatements()[0]->getControl();
        $maxPerPage = $this->getMaxPerPage();

        $totalRows = $query->count();

        $firstRow = $page*$maxPerPage + 1;
        $lastRow = $firstRow + $maxPerPage;


        $this->_feedback = "Displaying results $firstRow-$lastRow of $totalRows."
    }

    protected function setFeedbackByQuery($query) {

    }

}