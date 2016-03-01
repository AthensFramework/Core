<?php

namespace Athens\Core\Test;

use PHPUnit_Framework_TestCase;

use Athens\Core\Test\Mock\MockVisitor;
use Athens\Core\Test\Mock\MockVisitorWithGenericVisit;
use Athens\Core\Test\Mock\MockVisitableA;
use Athens\Core\Test\Mock\MockVisitableB;
use Athens\Core\Test\Mock\MockVisitableZ;

class VisitableTraitTest extends PHPUnit_Framework_TestCase
{

    public function testAccept()
    {
        $visitor = new MockVisitor();
        $host = new MockVisitableA();

        $host->accept($visitor);
        $this->assertEquals("A", $visitor->result);


        $visitor = new MockVisitor();
        $host = new MockVisitableB();

        $host->accept($visitor);
        $this->assertEquals("B", $visitor->result);
    }

    /**
     * @expectedException              \RuntimeException
     * @expectedExceptionMessageRegExp #No visit method.*#
     */
    public function testAcceptFails()
    {
        $visitor = new MockVisitor();
        $host = new MockVisitableZ();

        $host->accept($visitor);
    }

    public function testGenericAccept()
    {
        $visitor = new MockVisitorWithGenericVisit();
        $host = new MockVisitableZ();

        $host->accept($visitor);
        $this->assertEquals("generic", $visitor->result);

        $visitor = new MockVisitorWithGenericVisit();
        $host = new MockVisitableA();

        $host->accept($visitor);
        $this->assertEquals("A", $visitor->result);
    }
}
