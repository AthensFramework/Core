<?php

namespace UWDOEM\Framework\Table;


use UWDOEM\Framework\Filter\DummyFilter;
use UWDOEM\Framework\Row\RowInterface;
use UWDOEM\Framework\Filter\FilterInterface;


class TableBuilder {

    /**
     * @var RowInterface[]
     */
    protected $_rows = [];

    /**
     * @var FilterInterface
     */
    protected $_filter;

    protected function __construct() {
        $this->_filter = new DummyFilter();
    }

    /**
     * @param RowInterface[] $rows
     * @return TableBuilder
     */
    public function setRows($rows) {
        $this->_rows = $rows;
        return $this;
    }

    /**
     * @param FilterInterface $filter
     * @return TableBuilder
     */
    public function addFilter(FilterInterface $filter) {
        $filter->combine($this->_filter);
        $this->_filter = $filter;
        return $this;
    }

    /**
     * @return TableBuilder
     */
    public static function begin() {
        return new static();
    }

    public function build() {
        return new Table($this->_rows, $this->_filter);
    }


}