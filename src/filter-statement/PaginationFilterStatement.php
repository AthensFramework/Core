<?php

namespace UWDOEM\Framework\FilterStatement;

use Propel\Runtime\ActiveQuery\ModelCriteria;
use UWDOEM\Framework\Row\RowInterface;

/**
 * Class PaginationFilterStatement
 *
 * @package UWDOEM\Framework\FilterStatement
 */
class PaginationFilterStatement extends FilterStatement
{

    /**
     * @param ModelCriteria $query
     * @return ModelCriteria
     */
    public function applyToQuery(ModelCriteria $query)
    {

        $maxPerPage = $this->getCriterion();
        $page = $this->getControl();

        return $query->offset(($page - 1) * $maxPerPage)->limit($maxPerPage);
    }

    /**
     * @param RowInterface[] $rows
     * @return RowINterface[]
     */
    public function applyToRows(array $rows)
    {
        $maxPerPage = $this->getCriterion();
        $page = $this->getControl();

        return array_slice($rows, ($page - 1)*$maxPerPage, $maxPerPage);
    }
}
