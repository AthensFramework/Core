<?php

namespace UWDOEM\Framework\Table;


use UWDOEM\Framework\Filter\FilterInterface;
use UWDOEM\Framework\Row\RowInterface;
use UWDOEM\Framework\Visitor\VisitableTrait;


class Table implements TableInterface {

    protected $_filter;

    /**
     * @var RowInterface[]
     */
    protected $_rows = [];

    use VisitableTrait;

    /**
     * @param array $rows
     * @param FilterInterface $filter
     */
    public function __construct(array $rows, FilterInterface $filter) {
        $this->_rows = $rows;
        $this->_filter = $filter;
    }

    public function getRows() {
        return $this->_filter->rowFilter($this->_rows);
    }

    protected function getUnfilteredRows() {
        return $this->_rows;
    }

    public function getFilter() {
        return $this->_filter;
    }

}