<?php

namespace Athens\Core\Test;

use PHPUnit_Framework_TestCase;

use Athens\Core\Section\SectionBuilder;
use Athens\Core\Field\Field;

class SectionTest extends PHPUnit_Framework_TestCase
{

    /**
     * @return SectionBuilder[]
     */
    public function testedSectionBuilders()
    {
        // Return a fieldBearerBuilder of every type you want to test
        return [
            SectionBuilder::begin(),
        ];
    }

    /**
     * Basic tests for the Section builder classes.
     *
     * Any test here could potentially fail because of a failure in the constructed section.
     *
     * @throws \Exception
     */
    public function testBuilder()
    {
        $field = new Field([], [], "literal", "A literal field", []);

        $content = "content\ncontent";
        $label = "label";
        $writable = $field;
        $id = "s" . (string)rand();
        $classes = [(string)rand(), (string)rand()];
        $scriptContents = "c" . (string)rand();

        $section = SectionBuilder::begin()
            ->setId($id)
            ->addClass($classes[0])
            ->addClass($classes[1])
            ->addContent($content)
            ->addLabel($label)
            ->addScript($scriptContents)
            ->addWritable($writable)
            ->build();

        $this->assertEquals($id, $section->getId());
        $this->assertEquals($classes, $section->getClasses());
        $this->assertEquals(nl2br($content), $section->getWritables()[0]->getInitial());
        $this->assertEquals($label, $section->getWritables()[1]->getInitial());
        $this->assertEquals($scriptContents, $section->getWritables()[2]->getContents());
        $this->assertContains($writable, $section->getWritables());
        $this->assertEquals(4, sizeof($section->getWritables()));
        $this->assertEquals("base", $section->getType());
    }

    public function testGetWritableByHandle()
    {
        $field1 = new Field([], [], "literal", "A literal field", []);
        $field2 = new Field([], [], "literal", "A second literal field", []);

        $handle1 = "h" . (string)rand();
        $handle2 = "hh" . (string)rand();

        $id = "s" . (string)rand();

        $section = SectionBuilder::begin()
            ->setId($id)
            ->addWritable($field1, $handle1)
            ->addWritable($field2, $handle2)
            ->build();

        $this->assertEquals($field1, $section->getWritableByHandle($handle1));
        $this->assertEquals($field2, $section->getWritableByHandle($handle2));
    }
}
