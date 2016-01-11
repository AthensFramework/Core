<?php

namespace UWDOEM\Framework\Table;

use UWDOEM\Framework\Filter\FilterInterface;
use UWDOEM\Framework\Row\RowInterface;
use UWDOEM\Framework\Visitor\VisitableTrait;
use UWDOEM\Framework\Writer\WritableTrait;

/**
 * Class Table
 *
 * @package UWDOEM\Framework\Table
 */
class Table implements TableInterface
{

    /** @var FilterInterface */
    protected $filter;

    /** @var RowInterface[] */
    protected $rows = [];

    use VisitableTrait;
    use WritableTrait;

    /**
     * @param string          $id
     * @param string[]        $classes
     * @param array           $rows
     * @param FilterInterface $filter
     */
    public function __construct($id, array $classes, array $rows, FilterInterface $filter)
    {

        $this->rows = $rows;
        $this->classes = $classes;
        $this->filter = $filter;
        $this->id = $id;
    }

    /**
     * @return RowInterface[]
     */
    public function getRows()
    {
        return $this->filter->rowFilter($this->rows);
    }

    /**
     * @return RowInterface[]
     */
    protected function getUnfilteredRows()
    {
        return $this->rows;
    }

    /**
     * @return FilterInterface
     */
    public function getFilter()
    {
        return $this->filter;
    }
}
