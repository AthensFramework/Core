<?php

use UWDOEM\Framework\Visitor\Visitor;
use UWDOEM\Framework\Visitor\VisitableTrait;


class MockVisitor extends Visitor {

    public $result;

    function visitMockClassA($instance) {
        $this->result = "A";
    }

    function visitMockClassB($instance) {
        $this->result = "B";
    }

}

class MockVisitorWithGenericVisit extends MockVisitor {
    function visit($instance) {
        $this->result = "generic";
    }
}

class MockClassA {
    use VisitableTrait;
}

class MockClassB extends MockClassA { }

class MockClassZ {
    use VisitableTrait;
}


class VisitableTraitTest extends PHPUnit_Framework_TestCase {

    public function testAccept() {
        $visitor = new MockVisitor();
        $host = new MockClassA();

        $host->accept($visitor);
        $this->assertEquals("A", $visitor->result);


        $visitor = new MockVisitor();
        $host = new MockClassB();

        $host->accept($visitor);
        $this->assertEquals("B", $visitor->result);
    }

    /**
     * @expectedException              \RuntimeException
     * @expectedExceptionMessageRegExp #No visit method.*#
     */
    public function testAcceptFails() {
        $visitor = new MockVisitor();
        $host = new MockClassZ();

        $host->accept($visitor);
    }

    public function testGenericAccept() {
        $visitor = new MockVisitorWithGenericVisit();
        $host = new MockClassZ();

        $host->accept($visitor);
        $this->assertEquals("generic", $visitor->result);

        $visitor = new MockVisitorWithGenericVisit();
        $host = new MockClassA();

        $host->accept($visitor);
        $this->assertEquals("A", $visitor->result);
    }

}

