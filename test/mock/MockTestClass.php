<?php

namespace UWDOEM\Framework\Test\Mock;

use UWDOEMTest\TestClass;

class MockTestClass extends TestClass
{

    public $saved = false;

    public function save(\Propel\Runtime\Connection\ConnectionInterface $con = null)
    {
        $this->saved = true;
    }
}
