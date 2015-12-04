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


    public function getId() {
        $unfilteredRows = $this->getUnfilteredRows();

        if ($unfilteredRows) {
            $hash = md5(json_encode($unfilteredRows[0]->getFieldBearer()->getVisibleFieldNames()));
        } else {
            $hash = md5("table" . $_SERVER["REQUEST_URI"]);
        }

        return $hash;
    }

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