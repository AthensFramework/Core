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
            ->addFields([new Field("literal", "A literal field", [])])
            ->build();
        return new MockForm($fieldBearer, function(){}, function(){});
    }

    /**
     * Test that an initializer will init a form from post
     */
    public function testVisitForm() {
        $form = $this->makeMockForm();
        $initializer = new Initializer();

        $_SERVER["REQUEST_METHOD"] = "POST";

        // Assert that the form's fields do not yet have suffixes
        $this->assertEmpty($form->getFieldBearer()->getFields()[0]->getSuffixes());

        // Assert that the form has not yet been validated
        $this->assertEquals("", $form->result);

        // Visit the form with the initializer
        $initializer->visitForm($form);

        // Assert that the form has been validated
        $this->assertEquals("valid", $form->result);

        // Assert that the form's fields have been given prefixes
        $this->assertNotEmpty($form->getFieldBearer()->getFields()[0]->getSuffixes());

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
            ->addWritable($form)
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
                    ->addWritable($form)
                    ->build()
            )
            ->setType("full-header")
            ->build();
        $initializer->visitPage($page);

        $this->assertEquals("valid", $form->result);

    }

    public function testVisitFieldBearer() {
        $initializer = new Initializer();

        $field1 = new Field("literal", "A literal field", []);
        $field2 = new Field("literal", "A literal field", []);

        $fieldBearer1 = FieldBearerBuilder::begin()
            ->addFields([$field1])
            ->build();

        $fieldBearer2 = FieldBearerBuilder::begin()
            ->addFields([$field2])
            ->addFieldBearers([$fieldBearer1])
            ->build();

        // Assert that the fields do not yet have suffixes
        $this->assertEmpty($field1->getSuffixes());
        $this->assertEmpty($field2->getSuffixes());

        // Visit the field bearer tree
        $initializer->visitFieldBearer($fieldBearer2);

        // Assert that the fields now have suffixes
        $this->assertNotEmpty($field1->getSuffixes());
        $this->assertNotEmpty($field2->getSuffixes());
    }
}