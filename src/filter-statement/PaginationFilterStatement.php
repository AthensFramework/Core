<?php

namespace Athens\Core\FilterStatement;

use Propel\Runtime\ActiveQuery\ModelCriteria;
use Athens\Core\Row\RowInterface;

/**
 * Class PaginationFilterStatement
 *
 * @package Athens\Core\FilterStatement
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
     * @return RowInterface[]
     */
    public function applyToRows(array $rows)
    {
        return $rows;
    }
}
