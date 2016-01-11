<?php

namespace UWDOEM\Framework\Test;

use PHPUnit_Framework_TestCase;

use UWDOEM\Framework\FieldBearer\FieldBearerBuilder;
use UWDOEM\Framework\Field\Field;
use UWDOEM\Framework\Initializer\Initializer;
use UWDOEM\Framework\Section\SectionBuilder;
use UWDOEM\Framework\Page\PageBuilder;
use UWDOEM\Framework\Form\FormBuilder;
use UWDOEM\Framework\Field\FieldInterface;
use UWDOEM\Framework\PickA\PickAFormBuilder;

use UWDOEM\Framework\Test\Mock\MockForm;

class InitializerTest extends PHPUnit_Framework_TestCase
{

    protected function makeMockForm()
    {
        $fieldBearer = FieldBearerBuilder::begin()
            ->addFields([new Field("literal", "A literal field", [])])
            ->build();
        return new MockForm("f-" . (string)rand(), [], "base", "post", "_self", $fieldBearer, function () {
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
        $this->assertEmpty($form->getFieldBearer()->getFields()[0]->getSuffixes());

        // Assert that the form has not yet been validated
        $this->assertEquals("", $form->validated);

        // Visit the form with the initializer
        $initializer->visitForm($form);

        // Assert that the form has been validated
        $this->assertTrue($form->validated);

        // Assert that the form's fields have been given prefixes
        $this->assertNotEmpty($form->getFieldBearer()->getFields()[0]->getSuffixes());
    }

    /**
     * Test subforms get unique suffixes.
     */
    public function testUniqueSuffixesForSubforms()
    {
        $initializer = new Initializer();

        $fieldBearer1 = FieldBearerBuilder::begin()
            ->addFields([
                "field" => new Field('literal', 'A literal field', []),
                "field2" => new Field('literal', 'A second literal field', [])
            ])
            ->build();

        $fieldBearer2 = FieldBearerBuilder::begin()
            ->addFields([
                "field1" => new Field('literal', 'A literal field', []),
                "field2" => new Field('literal', 'A second literal field', [])
            ])
            ->build();

        $form1 = FormBuilder::begin()
            ->addFieldBearers([$fieldBearer1])
            ->setId("f-" . (string)rand())
            ->build();

        $form2 = FormBuilder::begin()
            ->addFieldBearers([$fieldBearer2])
            ->setId("f-" . (string)rand())
            ->build();

        $form = FormBuilder::begin()
            ->setId("f-" . (string)rand())
            ->addSubForms([
                "Form1" => $form1,
                "Form2" => $form2
            ])
            ->build();

        // Initialize the form to add suffixes
        $_SERVER["REQUEST_METHOD"] = "GET";
        $initializer->visitForm($form);

        // Grab all of the fields from both of the sub forms
        $fields = array_merge(
            array_values($form->getSubFormByName("Form1")->getFieldBearer()->getFields()),
            array_values($form->getSubFormByName("Form2")->getFieldBearer()->getFields())
        );

        // Map each field to a serialization of its suffixes
        $suffixes = array_map(
            function (FieldInterface $field) {
                return serialize($field->getSuffixes());
            },
            $fields
        );

        // Assert that every set of suffixes is unique
        $this->assertEquals(sizeof($suffixes), sizeof(array_unique($suffixes)));
    }

    /**
     * Test pick-a-forms get unique suffixes.
     */
    public function testUniqueSuffixesForPickAForms()
    {
        $initializer = new Initializer();

        $forms = [];
        for ($i = 0; $i <= 2; $i++) {
            $fieldBearer = FieldBearerBuilder::begin()
                ->addFields([
                    "field" => new Field('literal', 'A literal field', []),
                    "field2" => new Field('literal', 'A second literal field', [])
                ])
                ->build();

            $forms[] = FormBuilder::begin()
                ->setId("f-" . (string)rand())
                ->addFieldBearers([$fieldBearer])
                ->build();
        }

        $pickAForm = PickAFormBuilder::begin()
            ->setId("f-" . (string)rand())
            ->addForms([
                $forms[0],
                $forms[1]
            ])
            ->build();

        $form = FormBuilder::begin()
            ->setId("f-" . (string)rand())
            ->addSubForms([
                "PickA" => $pickAForm,
                "Form2" => $forms[2]
            ])
            ->build();

        // Initialize the form to add suffixes
        $_SERVER["REQUEST_METHOD"] = "GET";
        $initializer->visitForm($form);

        // Grab all of the fields from both of the sub forms
        $fields = array_merge(
            array_values($forms[0]->getFieldBearer()->getFields()),
            array_values($forms[1]->getFieldBearer()->getFields()),
            array_values($forms[2]->getFieldBearer()->getFields())
        );

        // Map each field to a serialization of its suffixes
        $suffixes = array_map(
            function (FieldInterface $field) {
                return serialize($field->getSuffixes());
            },
            $fields
        );

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
            ->setWritable(
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

    public function testVisitFieldBearer()
    {
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
