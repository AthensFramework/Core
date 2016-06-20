<?php

namespace Athens\Core\Test\Mock;

class MockColumn
{
    protected $phpName;
    protected $type;

    public function __construct($phpName, $type)
    {
        $this->phpName = $phpName;
        $this->type = $type;
    }

    public function getPhpName()
    {
        return $this->phpName;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getName()
    {
        return $this->phpName;
    }
}
