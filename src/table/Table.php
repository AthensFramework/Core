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
        return $this->filter();
    }

    protected function getUnfilteredRows() {
        return $this->_rows;
    }

//    public function getVisibleFieldLabels() {
//        if (isset($this->_fieldLabels)) {
//            return $this->_fieldLabels;
//        } elseif (sizeof($this->_rows) > 0) {
//            return $this->_rows[0]->getVisibleLabels();
//        } else {
//            return ["No Records Found"];
//        }
//    }

//    public function getVisibleFieldNames() {
//        if (sizeof($this->getUnfilteredRows()) > 0) {
//            return $this->getUnfilteredRows()[0]->getVisibleFieldNames();
//        } else {
//            return ["No Records Found"];
//        }
//    }

    public function getFilter() {
        return $this->_filter;
    }

    protected function filter() {
        $args = $this->getFilterArguments();

        $rows = $this->getUnfilteredRows();

        foreach ($this->getFilter() as $filter) {

            $filterArgs = array_key_exists($filter::NAME, $args) ? $args[$filter::NAME] : [];
            $rows = $filter->filter($filterArgs, $rows);
        }

        return $rows;
    }

    protected function queryFilter($query) {
        $args = $this->getFilterArguments();

        foreach ($this->getFilter() as $filter) {
            if (method_exists($filter, "queryFilter")) {
                $filterArgs = array_key_exists($filter::NAME, $args) ? $args[$filter::NAME] : [];
                $query = $filter->queryFilter($filterArgs, $query);
            }
        }

        return $query;

    }

    protected function getFilterArguments() {
        $arguments = [];
        foreach ($_GET as $key => $value) {
            $key = explode("-", $key);

            if (sizeof($key) == 2) {
                list($filter, $argname) = $key;

                if (!array_key_exists($filter, $arguments)) $arguments[$filter] = [];

                $arguments[$filter][$argname] = $value;
            }
        }
        return $arguments;
    }

}