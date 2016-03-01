<?php

namespace Athens\Core\Test\Mock;

class MockVisitorWithGenericVisit extends MockVisitor
{
    public function visit($instance)
    {
        $this->result = "generic";
    }
}
