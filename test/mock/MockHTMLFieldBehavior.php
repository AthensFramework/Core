<?php

namespace Athens\Core\Test\Mock;

use Athens\Core\Behavior\HTMLField;

class MockHTMLFieldBehavior extends HTMLField
{
    protected $table;
    protected $parameters;

    public function __construct($columns, $parameters)
    {
        $this->parameters = $parameters;
        $this->table = new MockTable($columns);
        parent::__construct();
    }

    public function getTable()
    {
        return $this->table;
    }
}
