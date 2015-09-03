<?php

use UWDOEM\Framework\Section\SectionBuilder;
use UWDOEM\Framework\Field\Field;


class SectionTest extends PHPUnit_Framework_TestCase
{

    /**
     * @return SectionBuilder[]
     */
    public function testedSectionBuilders() {
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
    public function testBuilder() {
        $field = new Field("literal", "A literal field", []);

        $content = "content";
        $label = "label";
        $writable = $field;

        $section = SectionBuilder::begin()
            ->setContent($content)
            ->setLabel($label)
            ->addWritable($writable)
            ->build();

        $this->assertEquals($content, $section->getContent());
        $this->assertEquals($label, $section->getLabel());
        $this->assertContains($writable, $section->getWritables());
        $this->assertEquals(1, sizeof($section->getWritables()));
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

