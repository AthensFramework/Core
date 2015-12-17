<?php

namespace UWDOEM\Framework\Test;

use PHPUnit_Framework_TestCase;

use UWDOEM\Framework\Test\Mock\MockVisitor;
use UWDOEM\Framework\Test\Mock\MockVisitorWithGenericVisit;
use UWDOEM\Framework\Test\Mock\MockVisitableA;
use UWDOEM\Framework\Test\Mock\MockVisitableB;
use UWDOEM\Framework\Test\Mock\MockVisitableZ;

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
