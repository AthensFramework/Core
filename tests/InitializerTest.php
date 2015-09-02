<?php

use UWDOEM\Framework\Form\Form;
use UWDOEM\Framework\FieldBearer\FieldBearerBuilder;
use UWDOEM\Framework\Field\Field;
use UWDOEM\Framework\Initializer\Initializer;
use UWDOEM\Framework\Section\SectionBuilder;
use UWDOEM\Framework\Page\PageBuilder;


class MockForm extends Form {

    public $result = "";

    public function isValid() {
        return true;
    }

    public function onValid() {
        $this->result = "valid";
    }
}


class InitializerTest extends PHPUnit_Framework_TestCase {

    protected function makeMockForm() {
        $fieldBearer = FieldBearerBuilder::begin()
            ->addFields([new Field("literal", "A literal field")])
            ->build();
        return new MockForm($fieldBearer, function(){}, function(){});
    }

    /**
     * Test that an initializer will init a form from post
     */
    public function testVisitForm() {
        $_SERVER["REQUEST_METHOD"] = "POST";
        $initializer = new Initializer();

        $form = $this->makeMockForm();
        $this->assertEquals("", $form->result);

        $initializer->visitForm($form);

        $this->assertEquals("valid", $form->result);
    }

    /**
     * Test that an initializer will initialize a section's form
     */
    public function testVisitSection() {
        $_SERVER["REQUEST_METHOD"] = "POST";
        $initializer = new Initializer();

        $form = $this->makeMockForm();
        $this->assertEquals("", $form->result);

        $section = SectionBuilder::begin()
            ->setWritables([$form])
            ->build();
        $initializer->visitSection($section);

        $this->assertEquals("valid", $form->result);
    }

    /**
     * Test that an initializer will initialize a page's section's form.
     */
    public function testVisitPage() {
        $_SERVER["REQUEST_METHOD"] = "POST";
        $initializer = new Initializer();

        $form = $this->makeMockForm();
        $this->assertEquals("", $form->result);

        $page = PageBuilder::begin()
            ->setWritable(
                SectionBuilder::begin()
                    ->setWritables([$form])
                    ->build()
            )
            ->setType("full-header")
            ->build();
        $initializer->visitPage($page);

        $this->assertEquals("valid", $form->result);

    }
}