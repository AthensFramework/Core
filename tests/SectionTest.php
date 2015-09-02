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
        $field = new Field("literal", "A literal field");

        $content = "content";
        $label = "label";
        $writables = [$field];

        $section = SectionBuilder::begin()
            ->setContent($content)
            ->setLabel($label)
            ->setWritables($writables)
            ->build();

        $this->assertEquals($content, $section->getContent());
        $this->assertEquals($label, $section->getLabel());
        $this->assertEquals($writables, $section->getWritables());
    }

    public function testInit() {
        $getString = (string)rand();
        $postString = (string)rand();

        $getCallback = function() use ($getString) { echo $getString; };
        $postCallback = function() use ($postString) { echo $postString; };

        $section = SectionBuilder::begin()
            ->setInitFromGet($getCallback)
            ->setInitFromPost($postCallback)
            ->build();

        /* Initialize the section from a GET request */
        $_SERVER['REQUEST_METHOD'] = "GET";

        ob_start();
        $section->init();
        $result = ob_get_clean();

        // Assert that our initFromGet method was called and echoed the desired content
        $this->assertContains($getString, $result);

        // Assert that our initFromPost method was not called
        $this->assertNotContains($postString, $result);


        /* Initialize the section from a GET request */
        $_SERVER['REQUEST_METHOD'] = "POST";

        ob_start();
        $section->init();
        $result = ob_get_clean();

        // Assert that our initFromPost method was called and echoed the desired content
        $this->assertContains($postString, $result);

        // Assert that our initFromGet method was not called
        $this->assertNotContains($getString, $result);


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

