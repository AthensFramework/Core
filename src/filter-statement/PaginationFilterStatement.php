<?php

namespace UWDOEM\Framework\FilterStatement;

use Propel\Runtime\ActiveQuery\ModelCriteria;


class PaginationFilterStatement extends FilterStatement {

    public function applyToQuery(ModelCriteria $query) {

        $maxPerPage = $this->getCriterion();
        $page = $this->getControl();

        return $query->offset(($page - 1) * $maxPerPage)->limit($maxPerPage);
    }

    public function applyToRows(array $rows) {
        $maxPerPage = $this->getCriterion();
        $page = $this->getControl();

        return array_slice($rows, ($page - 1)*$maxPerPage, $maxPerPage);
    }

}