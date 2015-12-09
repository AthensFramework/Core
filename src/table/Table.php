<?php

namespace UWDOEM\Framework\Table;

use UWDOEM\Framework\Filter\FilterInterface;
use UWDOEM\Framework\Row\RowInterface;
use UWDOEM\Framework\Visitor\VisitableTrait;

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
     * @param $id
     * @param array           $rows
     * @param FilterInterface $filter
     */
    public function __construct($id, array $rows, FilterInterface $filter)
    {

        $this->rows = $rows;
        $this->filter = $filter;
        $this->id = $id;
    }

    public function getRows()
    {
        return $this->filter->rowFilter($this->rows);
    }

    protected function getUnfilteredRows()
    {
        return $this->rows;
    }

    public function getFilter()
    {
        return $this->filter;
    }
}
