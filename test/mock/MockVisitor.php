<?php

namespace UWDOEM\Framework\Test\Mock;

use UWDOEM\Framework\Visitor\Visitor;

class MockVisitor extends Visitor
{

    public $result;

    public function visitMockVisitableA($instance)
    {
        $this->result = "A";
    }

    public function visitMockVisitableB($instance)
    {
        $this->result = "B";
    }
}
