<?php

namespace Athens\Core\Table;

use Athens\Core\Filter\FilterInterface;
use Athens\Core\Row\RowInterface;
use Athens\Core\Visitor\VisitableTrait;
use Athens\Core\Writer\WritableTrait;

/**
 * Class Table
 *
 * @package Athens\Core\Table
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
     * @param array           $data
     * @param array           $rows
     * @param FilterInterface $filter
     */
    public function __construct($id, array $classes, array $data, array $rows, FilterInterface $filter)
    {

        $this->rows = $rows;
        $this->classes = $classes;
        $this->filter = $filter;
        $this->id = $id;
        $this->data = $data;
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
