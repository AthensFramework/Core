<?php

namespace UWDOEM\Framework\Filter;


class PaginationFilter extends Filter {

    protected function getMaxPerPage() {
        return $this->getStatements()[0]->getCriterion();
    }

    protected function setOptionsByQuery($query) {
        $maxPerPage = $this->getMaxPerPage();
        $totalRows = $query->count();

        $numPages = ceil($totalRows / $maxPerPage);

        $this->_options = range(1, $numPages);
    }

    protected function makeFeedback() {
        return "Pagination feedback";
    }

}