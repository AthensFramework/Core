<?php

namespace UWDOEM\Framework\Table;

use UWDOEM\Framework\Row\RowInterface;
use UWDOEM\Framework\Filter\FilterInterface;
use UWDOEM\Framework\Writer\WritableInterface;

interface TableInterface extends WritableInterface
{

    /**
     * @return RowInterface[]
     */
    function getRows();

    /**
     * @return FilterInterface
     */
    function getFilter();
}
