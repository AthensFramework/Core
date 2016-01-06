<?php

namespace UWDOEM\Framework\Table;

use UWDOEM\Framework\Filter\FilterInterface;
use UWDOEM\Framework\Row\RowInterface;
use UWDOEM\Framework\Visitor\VisitableTrait;

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

    /** @var string */
    protected $id;

    use VisitableTrait;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string          $id
     * @param array           $rows
     * @param FilterInterface $filter
     */
    public function __construct($id, array $rows, FilterInterface $filter)
    {

        $this->rows = $rows;
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
