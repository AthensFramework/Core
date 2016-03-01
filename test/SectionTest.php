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
        $field = new Field([], "literal", "A literal field", []);

        $content = "content\ncontent";
        $label = "label";
        $writable = $field;
        $id = "s" . (string)rand();
        $classes = [(string)rand(), (string)rand()];

        $section = SectionBuilder::begin()
            ->setId($id)
            ->addClass($classes[0])
            ->addClass($classes[1])
            ->addContent($content)
            ->addLabel($label)
            ->addWritable($writable)
            ->build();

        $this->assertEquals($id, $section->getId());
        $this->assertEquals($classes, $section->getClasses());
        $this->assertEquals(nl2br($content), $section->getWritables()[0]->getInitial());
        $this->assertEquals($label, $section->getWritables()[1]->getInitial());
        $this->assertContains($writable, $section->getWritables());
        $this->assertEquals(3, sizeof($section->getWritables()));
        $this->assertEquals("base", $section->getType());
    }

    /*
     * The below methods are tested sufficiently above
    public function testGetWritables() {

    }

    public function testGetLabel() {

    }

    public function testGetContent() {

    }
    */
}
