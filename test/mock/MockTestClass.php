<?php

namespace Athens\Core\Test\Mock;

use AthensTest\TestClass;

class MockTestClass extends TestClass
{

    public $saved = false;

    public function save(\Propel\Runtime\Connection\ConnectionInterface $con = null)
    {
        $this->saved = true;
    }
}
