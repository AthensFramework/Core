<?php

namespace Athens\Core\FilterStatement;

use Athens\Core\QueryWrapper\QueryWrapperInterface;
use Athens\Core\Row\RowInterface;

/**
 * Class PaginationFilterStatement
 *
 * @package Athens\Core\FilterStatement
 */
class PaginationFilterStatement extends FilterStatement
{

    /**
     * @param QueryWrapperInterface $query
     * @return QueryWrapperInterface
     */
    public function applyToQuery(QueryWrapperInterface $query)
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
