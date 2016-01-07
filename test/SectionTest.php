<?php

namespace UWDOEM\Framework\Test;

use PHPUnit_Framework_TestCase;

use UWDOEM\Framework\Section\SectionBuilder;
use UWDOEM\Framework\Field\Field;

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
        $field = new Field("literal", "A literal field", []);

        $content = "content\ncontent";
        $label = "label";
        $writable = $field;
        $id = "s" . (string)rand();

        $section = SectionBuilder::begin()
            ->setId($id)
            ->addContent($content)
            ->addLabel($label)
            ->addWritable($writable)
            ->build();

        $this->assertEquals($id, $section->getId());
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
