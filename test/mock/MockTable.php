<?php

namespace Athens\Core\Test\Mock;

class MockTable
{
    /** @var  array */
    protected $columns;

    public function __construct($columns)
    {
        $this->columns = $columns;
    }

    public function getColumn($columnName)
    {
        return $this->columns[$columnName];
    }

    public function getColumnByPhpName($columnName)
    {
        return $this->columns[$columnName];
    }

    public function getColumns()
    {
        return $this->columns;
    }

    public function getName()
    {
        return "table_name";
    }
}
