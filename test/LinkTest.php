<?php

namespace Athens\Core\Test;

use Athens\Core\Link\Link;
use PHPUnit_Framework_TestCase;

use Athens\Core\Link\LinkBuilder;

class LinkTest extends PHPUnit_Framework_TestCase
{

    public function testBuilder()
    {
        $type = "type";
        $classes = ["class1", "class2"];
        $uri = "example uri";
        $text = "example text";

        $link = LinkBuilder::begin()
            ->setType($type)
            ->addClass($classes[0])
            ->addClass($classes[1])
            ->setURI($uri)
            ->setText($text)
            ->build();

        $this->assertEquals($type, $link->getType());
        $this->assertEquals($uri, $link->getURI());
        $this->assertEquals($text, $link->getText());
        $this->assertContains($classes[0], $link->getClasses());
        $this->assertContains($classes[1], $link->getClasses());
    }

    /**
     * @expectedException              \Exception
     * @expectedExceptionMessageRegExp #Must use ::setURI.*#
     */
    public function testBuilderNoTypeException()
    {
        LinkBuilder::begin()->setText('example text')->build();
    }

    /**
     * @expectedException              \Exception
     * @expectedExceptionMessageRegExp #Must use ::setText.*#
     */
    public function testBuilderNoLabelException()
    {
        LinkBuilder::begin()->setURI('example text')->build();
    }
}
