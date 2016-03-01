<?php

namespace Athens\Core\Test\Mock;

use Athens\Core\Visitor\Visitor;

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
