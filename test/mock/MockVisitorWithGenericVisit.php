<?php

namespace UWDOEM\Framework\Test\Mock;

class MockVisitorWithGenericVisit extends MockVisitor
{
    public function visit($instance)
    {
        $this->result = "generic";
    }
}
