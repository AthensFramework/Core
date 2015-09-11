<?php

use UWDOEM\Framework\Form\FormBuilder;
use UWDOEM\Framework\Form\FormAction\FormAction;
use UWDOEM\Framework\Field\Field;
use UWDOEM\Framework\Etc\ORMUtils;
use UWDOEM\Framework\FieldBearer\FieldBearerBuilder;
use UWDOEM\Framework\FieldBearer\FieldBearer;
use UWDOEM\Framework\Field\FieldInterface;
use UWDOEM\Framework\Form\FormInterface;
use \UWDOEMTest\TestClass;

class MockFieldBearer extends FieldBearer {

    public static $saved = false;

    public function __construct() {}

    public function save() {
        static::$saved = true;
    }
}


class FormTest extends PHPUnit_Framework_TestCase {

    /**
     * Basic tests for the Form builder classes.
     *
     * Any test here could potentially fail because of a failure in the constructed form.
     *
     * @throws \Exception
     */
    public function testBuilder() {

        $actions = [new FormAction("label", "method", "")];
        $onValidFunc = function () {
            return "valid";
        };
        $onInvalidFunc = function () {
            return "invalid";
        };

        $fields = ["field" => new Field('literal', 'A literal field', [])];

        $form = FormBuilder::begin()
            ->clear()
            ->setActions($actions)
            ->addFields($fields)
            ->setOnInvalidFunc($onInvalidFunc)
            ->setOnValidFunc($onValidFunc)
            ->setVisibleFieldNames(array_keys($fields))
            ->build();

        $this->assertEquals($actions, $form->getActions());
        $this->assertEquals($fields, $form->getFieldBearer()->getFields());
        $this->assertEquals(array_keys($fields), $form->getFieldBearer()->getVisibleFieldNames());

        $this->assertEquals("valid", $form->onValid());
        $this->assertEquals("invalid", $form->onInvalid());

        /* Test FormBuilder creation of ClassFieldBearer */
        $object = new TestClass();

        $form = FormBuilder::begin()->clear()
            ->addObject($object)
            ->build();

        $expectedFieldNames = array_keys(ORMUtils::makeFieldsFromObject($object));
        $this->assertEquals($expectedFieldNames, $form->getFieldBearer()->getVisibleFieldNames());

        /* Test FormBuilder::addFieldBearer */
        $fields = ["field" => new Field('literal', 'A literal field', [])];

        $fieldBearer = FieldBearerBuilder::begin()
            ->addFields($fields)
            ->build();

        $form = FormBuilder::begin()
            ->addFieldBearer($fieldBearer)
            ->build();

        $this->assertContains("field", $form->getFieldBearer()->getFieldNames());
    }

    /**
     * Tests whether we can set a success-url in the FormBuilder.
     *
     * Actually, this test asserts that the onValid function will raise an (appropriate) error in
     * testing instead of executing a redirect.
     *
     * @expectedException              Exception
     * @expectedExceptionMessageRegExp #success redirection cannot proceed.*#
     */
    public function testSetOnSuccessUrl() {
        $form = FormBuilder::begin()
            ->addFields(["field" => new Field('literal', 'A literal field', [])])
            ->setOnSuccessUrl("http://example.com")
            ->build();

        $form->onValid();
    }
    
    public function testDefaultFormAction() {
        $fields = ["field" => new Field('literal', 'A literal field', [])];

        $form = FormBuilder::begin()
            ->addFields($fields)
            ->build();

        $this->assertEquals(1, sizeof($form->getActions()));
        $this->assertEquals("POST", $form->getActions()[0]->getMethod());
        $this->assertEquals("Submit", $form->getActions()[0]->getLabel());
    }

    public function testFormAddError() {
        $fields = ["field" => new Field('literal', 'A literal field', [])];

        $form = FormBuilder::begin()
            ->addFields($fields)
            ->build();

        $errorText = (string)rand();

        $form->addError($errorText);

        $this->assertFalse($form->isValid());
        $this->assertContains($errorText, $form->getErrors());
    }

    public function testEndogenousValidation() {

        $requiredField = new Field('text', 'A required field', "", true, []);
        $unrequiredField = new Field('text', 'A required field', "", false, []);

        $fields = ["required" => $requiredField, "unrequired" => $unrequiredField];


        /* Do not provide input to the field which requires input */
        $form = FormBuilder::begin()
            ->addFields($fields)
            ->build();

        // The required field has not been provided, the form should not be valid
        $this->assertFalse($form->isValid());

        /* Provide input to the field which requires input */
        $form = FormBuilder::begin()
            ->addFields($fields)
            ->build();
        $requiredField->removeErrors();

        // Provide input for the required field
        $_POST[$requiredField->getSlug()] = (string)rand();

        // The required field has been provided, the form should be valid.
        $this->assertTrue($form->isValid());
    }

    public function testExogenousValidation() {
        $unrequiredField = new Field('text', 'An unrequired field', "", false, []);
        $specificField = new Field("text", "A field which required specific input.", []);
        $fields = ["specific" => $specificField, "unrequired" => $unrequiredField];

        $requiredInput = "the specific input required";

        $validator = function(FieldInterface $field) use ($requiredInput) {
            $input = $field->getSubmitted();
            if ($input !== $requiredInput) {
                $field->addError("The exact specific input was not provided.");
            }
        };


        /* Provide no input for the specific field */
        $form = FormBuilder::begin()
            ->addFields($fields)
            ->addValidator("specific", $validator)
            ->build();

        // No input was provided, the form is not valid
        $this->assertFalse($form->isValid());


        /* Provide the wrong input to the specific field */
        $specificField->removeErrors();
        $form = FormBuilder::begin()
            ->addFields($fields)
            ->addValidator("specific", $validator)
            ->build();

        $_POST[$specificField->getSlug()] = (string)rand();

        // Input was provided, but not the specific input required, form is not valid
        $this->assertFalse($form->isValid());


        /* Provide the correct input to the specific field */
        $specificField->removeErrors();
        $form = FormBuilder::begin()
            ->addFields($fields)
            ->addValidator("specific", $validator)
            ->build();

        $_POST[$specificField->getSlug()] = $requiredInput;

        // Correct input was provided, field should be valid
        $this->assertTrue($form->isValid());
    }

    /**
     * Test that the validators included via addValidator are passed the form
     */
    public function testExogenousValidationGetsPassedForm() {
        $field = new Field('text', 'A special field', "", false, []);

        $errorText = (string)rand();

        $validator = function(FieldInterface $field, FormInterface $form) use ($errorText) {
            $form->addError($errorText);
        };

        $form = FormBuilder::begin()
            ->addFields(["field" => $field])
            ->addValidator("field", $validator)
            ->build();

        $this->assertFalse($form->isValid());

        $this->assertContains($errorText, $form->getErrors());
    }

    public function testDefaultOnInvalid() {
        $requiredField = new Field('text', 'A required field', "", true, []);
        $unrequiredField = new Field('text', 'An unrequired field', "", false, []);

        $fields = ["required" => $requiredField, "unrequired" => $unrequiredField];

        $form = FormBuilder::begin()
            ->addFields($fields)
            ->build();

        // Provide input to the field that does not require input
        $input = (string)rand();
        $_POST[$unrequiredField->getSlug()] = $input;

        // Assert that the unrequired field does not have an "initial" value
        $this->assertNotEquals($input, $unrequiredField->getInitial());

        // Trigger the form's onInvalid method
        $form->onInvalid();

        // Assert that the input has been moved into the field's initial value
        $this->assertEquals($input, $unrequiredField->getInitial());
    }

    public function testDefaultOnValid() {
        $unrequiredField = new Field('text', 'An unrequired field', "", false, []);

        $fields = ["unrequired" => $unrequiredField];

        $fieldBearer = new MockFieldBearer();

        $form = FormBuilder::begin()
            ->addFieldBearer($fieldBearer)
            ->build();

        // Trigger the form's onInvalid method
        $form->onValid();

        // Assert that the input has been moved into the field's initial value
        $this->assertTrue(MockFieldBearer::$saved);
    }
}

