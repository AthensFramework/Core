<?php

namespace Athens\Core\Test\Mock;

use Athens\Core\Visitor\VisitorInterface;

class MockVisitor implements VisitorInterface
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
