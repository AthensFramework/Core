<?php

namespace Athens\Core\Table;

use Athens\Core\Row\RowInterface;
use Athens\Core\Filter\FilterInterface;
use Athens\Core\Writer\WritableInterface;

interface TableInterface extends WritableInterface
{

    /**
     * @return RowInterface[]
     */
    public function getRows();

    /**
     * @return FilterInterface
     */
    public function getFilter();
}
