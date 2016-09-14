<?php

namespace Athens\Core\Test;

use PHPUnit_Framework_TestCase;

use Athens\Core\WritableBearer\WritableBearerBuilder;
use Athens\Core\Field\Field;
use Athens\Core\Initializer\Initializer;
use Athens\Core\Section\SectionBuilder;
use Athens\Core\Page\PageBuilder;
use Athens\Core\Form\FormBuilder;
use Athens\Core\Field\FieldInterface;

use Athens\Core\Test\Mock\MockForm;

class InitializerTest extends PHPUnit_Framework_TestCase
{

    protected function makeMockForm()
    {
        $fieldBearer = WritableBearerBuilder::begin()
            ->addWritable(new Field([], [], "literal", "A literal field", []))
            ->build();
        return new MockForm("f-" . (string)rand(), [], [], "base", "post", "_self", $fieldBearer, function () {
        }, function () {
        });
    }

    /**
     * Test that an initializer will init a form from post
     */
    public function testVisitForm()
    {
        $form = $this->makeMockForm();
        $initializer = new Initializer();

        $_SERVER["REQUEST_METHOD"] = "POST";

        // Assert that the form's fields do not yet have suffixes
        $this->assertEmpty($form->getWritableBearer()->getWritables()[0]->getSuffixes());

        // Assert that the form has not yet been validated
        $this->assertEquals("", $form->validated);

        // Visit the form with the initializer
        $initializer->visitForm($form);

        // Assert that the form has been validated
        $this->assertTrue($form->validated);

        // Assert that the form's fields have been given prefixes
        $this->assertNotEmpty($form->getWritableBearer()->getWritables()[0]->getSuffixes());
    }

    /**
     * Test subforms get unique suffixes.
     */
    public function testUniqueSuffixesForSubforms()
    {
        $initializer = new Initializer();

        $fieldBearer1 = WritableBearerBuilder::begin()
            ->addWritable(new Field([], [], 'literal', 'A literal field', [], "field"))
            ->addWritable(new Field([], [], 'literal', 'A second literal field', []), "field2")
            ->build();

        $fieldBearer2 = WritableBearerBuilder::begin()
            ->addWritable(new Field([], [], 'literal', 'A literal field', [], "field"))
            ->addWritable(new Field([], [], 'literal', 'A second literal field', []), "field2")
            ->build();

        $form1 = FormBuilder::begin()
            ->addWritableBearer($fieldBearer1)
            ->setId("f-" . (string)rand())
            ->build();

        $form2 = FormBuilder::begin()
            ->addWritableBearer($fieldBearer2)
            ->setId("f-" . (string)rand())
            ->build();

        $form = FormBuilder::begin()
            ->setId("f-" . (string)rand())
            ->addWritable($form1, 'Form1')
            ->addWritable($form2, 'Form2')
            ->build();

        // Initialize the form to add suffixes
        $_SERVER["REQUEST_METHOD"] = "GET";
        $initializer->visitForm($form);

        // Grab all of the fields from both of the sub forms
        $writables = array_merge(
            array_values($form->getWritableBearer()->getWritableByHandle("Form1")->getWritableBearer()->getWritables()),
            array_values($form->getWritableBearer()->getWritableByHandle("Form2")->getWritableBearer()->getWritables())
        );

        // Map each field to a serialization of its suffixes
        $suffixes = [];
        foreach ($writables as $writable) {
            if ($writable instanceof FieldInterface) {
                $suffixes[] = serialize($writable->getSuffixes());
            }
        }

        // Assert that every set of suffixes is unique
        $this->assertEquals(sizeof($suffixes), sizeof(array_unique($suffixes)));
    }

    /**
     * Test that an initializer will initialize a section's form
     */
    public function testVisitSection()
    {
        $_SERVER["REQUEST_METHOD"] = "POST";
        $initializer = new Initializer();

        $form = $this->makeMockForm();
        $this->assertEquals("", $form->validated);

        $section = SectionBuilder::begin()
            ->setId("s" . (string)rand())
            ->addWritable($form)
            ->build();
        $initializer->visitSection($section);

        $this->assertTrue($form->validated);
    }

    /**
     * Test that an initializer will initialize a page's section's form.
     */
    public function testVisitPage()
    {
        $_SERVER["REQUEST_METHOD"] = "POST";
        $initializer = new Initializer();

        $form = $this->makeMockForm();
        $this->assertEquals("", $form->validated);

        $page = PageBuilder::begin()
            ->setId("test-page")
            ->addWritable(
                SectionBuilder::begin()
                    ->setId("s" . (string)rand())
                    ->addWritable($form)
                    ->build()
            )
            ->setType("full-header")
            ->build();
        $initializer->visitPage($page);

        $this->assertTrue($form->validated);
    }

//    public function testVisitFieldBearer()
//    {
//        $initializer = new Initializer();
//
//        $field1 = new Field([], [], "literal", "A literal field", []);
//        $field2 = new Field([], [], "literal", "A literal field", []);
//
//        $fieldBearer1 = WritableBearerBuilder::begin()
//            ->addWritable($field1)
//            ->build();
//
//        $fieldBearer2 = WritableBearerBuilder::begin()
//            ->addWritable($field2)
//            ->addWritableBearer($fieldBearer1)
//            ->build();
//
//        // Assert that the fields do not yet have suffixes
//        $this->assertEmpty($field1->getSuffixes());
//        $this->assertEmpty($field2->getSuffixes());
//
//        // Visit the field bearer tree
//        $initializer->visitWritableBearer($fieldBearer2);
//
//        // Assert that the fields now have suffixes
//        $this->assertNotEmpty($field1->getSuffixes());
//        $this->assertNotEmpty($field2->getSuffixes());
//    }
}
