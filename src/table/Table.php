<?php

namespace UWDOEM\Framework\Table;

use UWDOEM\Framework\Filter\FilterInterface;
use UWDOEM\Framework\Row\RowInterface;
use UWDOEM\Framework\Visitor\VisitableTrait;


class Table implements TableInterface {

    /** @var FilterInterface */
    protected $_filter;

    /** @var RowInterface[] */
    protected $_rows = [];

    /** @var string */
    protected $_id;

    use VisitableTrait;

    /**
     * @return string
     */
    public function getId() {
        return $this->_id;
    }

    /**
     * @param $id
     * @param array $rows
     * @param FilterInterface $filter
     */
    public function __construct($id, array $rows, FilterInterface $filter) {

        $this->_rows = $rows;
        $this->_filter = $filter;
        $this->_id = $id;
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