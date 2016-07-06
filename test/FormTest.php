<?php

namespace Athens\Core\Test;

use PHPUnit_Framework_TestCase;

use Athens\Core\Form\FormBuilder;
use Athens\Core\Form\FormAction\FormAction;
use Athens\Core\Field\Field;
use Athens\Core\Etc\ORMUtils;
use Athens\Core\FieldBearer\FieldBearerBuilder;
use Athens\Core\Field\FieldInterface;
use Athens\Core\Form\FormInterface;
use Athens\Core\Choice\ChoiceBuilder;

use Athens\Core\Test\Mock\MockFieldBearer;

use AthensTest\TestClass;

class FormTest extends PHPUnit_Framework_TestCase
{

    /**
     * Basic tests for the Form builder classes.
     *
     * Any test here could potentially fail because of a failure in the constructed form.
     *
     * @throws \Exception
     */
    public function testBuilder()
    {

        $actions = [new FormAction([], [], "label", "method", "")];
        $onValidFunc = function () {
            return "valid";
        };
        $onInvalidFunc = function () {
            return "invalid";
        };

        $fields = ["field" => new Field([], [], 'literal', 'A literal field', [])];

        $id = "f" . (string)rand();
        $type = "t" . (string)rand();
        $method = "m" . (string)rand();
        $target = "t" . (string)rand();
        $classes = [(string)rand(), (string)rand()];

        $form = FormBuilder::begin()
            ->clear()
            ->setId($id)
            ->addClass($classes[0])
            ->addClass($classes[1])
            ->setType($type)
            ->setMethod($method)
            ->setTarget($target)
            ->setActions($actions)
            ->addFields($fields)
            ->setOnInvalidFunc($onInvalidFunc)
            ->setOnValidFunc($onValidFunc)
            ->setVisibleFieldNames(array_keys($fields))
            ->build();

        $this->assertEquals($actions, $form->getActions());
        $this->assertEquals($fields, $form->getFieldBearer()->getFields());
        $this->assertEquals(array_keys($fields), $form->getFieldBearer()->getVisibleFieldNames());
        $this->assertEquals($id, $form->getId());
        $this->assertEquals($classes, $form->getClasses());
        $this->assertEquals($type, $form->getType());
        $this->assertEquals($method, $form->getMethod());
        $this->assertEquals($target, $form->getTarget());

        $this->assertEquals("valid", $form->onValid());
        $this->assertEquals("invalid", $form->onInvalid());

        /* Test default type/method/target */
        $form = FormBuilder::begin()
            ->setId($id)
            ->build();

        $this->assertEquals("base", $form->getType());
        $this->assertEquals("post", $form->getMethod());
        $this->assertEquals("_self", $form->getTarget());

        /* Test FormBuilder creation of ClassFieldBearer */
        $object = new TestClass();

        $form = FormBuilder::begin()->clear()
            ->setId("f-" . (string)rand())
            ->addObject($object)
            ->build();

        $expectedFieldNames = array_keys(ORMUtils::makeFieldsFromObject($object));
        $this->assertEquals($expectedFieldNames, $form->getFieldBearer()->getFieldNames());

        /* Test FormBuilder::addFieldBearer */
        $fields = ["field" => new Field([], [], 'literal', 'A literal field', [])];

        $fieldBearer = FieldBearerBuilder::begin()
            ->addFields($fields)
            ->build();

        $form = FormBuilder::begin()
            ->setId("f-" . (string)rand())
            ->addFieldBearers([$fieldBearer])
            ->build();

        $this->assertContains("field", $form->getFieldBearer()->getFieldNames());

        /* Test FormBuilder::addSubForms */
        $fields = ["field" => new Field([], [], 'literal', 'A literal field', [])];

        $fieldBearer = FieldBearerBuilder::begin()
            ->addFields($fields)
            ->build();

        $form1 = FormBuilder::begin()
            ->setId("f-" . (string)rand())
            ->addFieldBearers([$fieldBearer])
            ->build();

        $form2 = FormBuilder::begin()
            ->setId("f-" . (string)rand())
            ->addFieldBearers([$fieldBearer])
            ->build();

        $form = FormBuilder::begin()
            ->setId("f-" . (string)rand())
            ->addSubForms([
                "Form1" => $form1,
                "Form2" => $form2
            ])
            ->build();

        $this->assertEquals(2, sizeof($form->getSubForms()));
        $this->assertContains($form1, $form->getSubForms());
        $this->assertContains($form2, $form->getSubForms());
    }

    public function testMakeLiteralWithFormBuilder()
    {
        $label = new Field([], [], FieldBuilder::TYPE_SECTION_LABEL, "section label");
        $field1 = new Field([], [], FieldBuilder::TYPE_BOOLEAN, "", []);
        $field2 = new Field([], [], FieldBuilder::TYPE_TEXT, "", []);

        $fields = [
            "label" => $label,
            "field1" => $field1,
            "field2" => $field2
        ];

        $form = FormBuilder::begin()
            ->setId("f-" . (string)rand())
            ->addFields($fields)
            ->makeLiteral()
            ->build();

        foreach ($form->getFieldBearer()->getFields() as $name => $field) {
            if ($name === "label") {
                $this->assertEquals(FieldBuilder::TYPE_SECTION_LABEL, $field->getType());
            } else {
                $this->assertEquals(FieldBuilder::TYPE_LITERAL, $field->getType());
            }
        }
    }

    public function testSetFieldValuesWithFormBuilder()
    {
        $field1 = new Field([], [], "literal", "", []);
        $field2 = new Field([], [], "literal", "", []);

        $fields = [
            "field1" => $field1,
            "field2" => $field2
        ];

        $newInitialValue = (string)rand();
        $newLabel = (string)rand();
        $newChoices = [
            ChoiceBuilder::begin()->setValue(rand())->build(),
            ChoiceBuilder::begin()->setValue(rand())->build(),
            ChoiceBuilder::begin()->setValue(rand())->build(),
        ];

        FormBuilder::begin()
            ->setId("f-" . (string)rand())
            ->addFields($fields)
            ->setInitialFieldValue("field1", $newInitialValue)
            ->setFieldLabel("field1", $newLabel)
            ->setFieldChoices("field1", $newChoices)
            ->build();

        $this->assertEquals($newInitialValue, $field1->getInitial());
        $this->assertEquals($newLabel, $field1->getLabel());
        $this->assertEquals(array_values($newChoices), array_values($field1->getChoices()));
    }

    public function testLabelFieldCreation()
    {
        $labelText = (string)rand();

        $form = FormBuilder::begin()
            ->setId("f-" . (string)rand())
            ->addLabel($labelText)
            ->build();

        $labelField = $form->getFieldBearer()->getFields()[0];

        $this->assertEquals(FieldBuilder::TYPE_SECTION_LABEL, $labelField->getType());
        $this->assertEquals($labelText, $labelField->getLabel());
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
    public function testSetOnSuccessUrl()
    {
        $form = FormBuilder::begin()
            ->setId("f-" . (string)rand())
            ->addFields(["field" => new Field([], [], 'literal', 'A literal field', [])])
            ->setOnSuccessUrl("http://example.com")
            ->build();

        $form->onValid();
    }
    
    public function testDefaultFormAction()
    {
        $fields = ["field" => new Field([], [], 'literal', 'A literal field', [])];

        $form = FormBuilder::begin()
            ->setId("f-" . (string)rand())
            ->addFields($fields)
            ->build();

        $this->assertEquals(1, sizeof($form->getActions()));
        $this->assertEquals("POST", $form->getActions()[0]->getMethod());
        $this->assertEquals("Submit", $form->getActions()[0]->getLabel());
    }

    /**
     * Test can retrieve a subform by assigned name
     */
    public function testGetSubformByName()
    {
        $fields = ["field" => new Field([], [], 'literal', 'A literal field', [])];

        $fieldBearer = FieldBearerBuilder::begin()
            ->addFields($fields)
            ->build();

        $form1 = FormBuilder::begin()
            ->setId("f-" . (string)rand())
            ->addFieldBearers([$fieldBearer])
            ->build();

        $form2 = FormBuilder::begin()
            ->setId("f-" . (string)rand())
            ->addFieldBearers([$fieldBearer])
            ->build();

        $form = FormBuilder::begin()
            ->setId("f-" . (string)rand())
            ->addSubForms([
                "Form1" => $form1,
                "Form2" => $form2
            ])
            ->build();

        $this->assertEquals($form1, $form->getSubFormByName("Form1"));
        $this->assertEquals($form2, $form->getSubFormByName("Form2"));
    }

    public function testFormAddError()
    {
        $fields = ["field" => new Field([], [], 'literal', 'A literal field', [])];

        $form = FormBuilder::begin()
            ->setId("f-" . (string)rand())
            ->addFields($fields)
            ->build();

        $errorText = (string)rand();

        $form->addError($errorText);

        $this->assertFalse($form->isValid());
        $this->assertContains($errorText, $form->getErrors());
    }

    public function testEndogenousValidation()
    {

        $requiredField = new Field([], [], 'text', 'A required field', "", true, []);
        $unrequiredField = new Field([], [], 'text', 'A required field', "", false, []);

        $fields = ["required" => $requiredField, "unrequired" => $unrequiredField];


        /* Do not provide input to the field which requires input */
        $form = FormBuilder::begin()
            ->setId("f-" . (string)rand())
            ->addFields($fields)
            ->build();

        // The required field has not been provided, the form should not be valid
        $this->assertFalse($form->isValid());

        /* Provide input to the field which requires input */
        $form = FormBuilder::begin()
            ->setId("f-" . (string)rand())
            ->addFields($fields)
            ->build();
        $requiredField->removeErrors();

        // Provide input for the required field
        $_POST[$requiredField->getSlug()] = (string)rand();

        // The required field has been provided, the form should be valid.
        $this->assertTrue($form->isValid());
    }

    public function testExogenousValidation()
    {
        $unrequiredField = new Field([], [], 'text', 'An unrequired field', "", false, []);
        $specificField = new Field([], [], "text", "A field which required specific input.", []);
        $fields = ["specific" => $specificField, "unrequired" => $unrequiredField];

        $requiredInput = "the specific input required";

        $validator = function (FieldInterface $field) use ($requiredInput) {
            $input = $field->getSubmitted();
            if ($input !== $requiredInput) {
                $field->addError("The exact specific input was not provided.");
            }
        };


        /* Provide no input for the specific field */
        $form = FormBuilder::begin()
            ->setId("f-" . (string)rand())
            ->addFields($fields)
            ->addValidator("specific", $validator)
            ->build();

        // No input was provided, the form is not valid
        $this->assertFalse($form->isValid());


        /* Provide the wrong input to the specific field */
        $specificField->removeErrors();
        $form = FormBuilder::begin()
            ->setId("f-" . (string)rand())
            ->addFields($fields)
            ->addValidator("specific", $validator)
            ->build();

        $_POST[$specificField->getSlug()] = (string)rand();

        // Input was provided, but not the specific input required, form is not valid
        $this->assertFalse($form->isValid());


        /* Provide the correct input to the specific field */
        $specificField->removeErrors();
        $form = FormBuilder::begin()
            ->setId("f-" . (string)rand())
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
    public function testExogenousValidationGetsPassedForm()
    {
        $field = new Field([], [], 'text', 'A special field', "", false, []);

        $errorText = (string)rand();

        $validator = function (FieldInterface $field, FormInterface $form) use ($errorText) {
            $form->addError($errorText);
        };

        $form = FormBuilder::begin()
            ->setId("f-" . (string)rand())
            ->addFields(["field" => $field])
            ->addValidator("field", $validator)
            ->build();

        $this->assertFalse($form->isValid());

        $this->assertContains($errorText, $form->getErrors());
    }

    public function testDefaultOnInvalid()
    {
        $requiredField = new Field([], [], 'text', 'A required field', "", true, []);
        $unrequiredField = new Field([], [], 'text', 'An unrequired field', "", false, []);

        $fields = ["required" => $requiredField, "unrequired" => $unrequiredField];

        $form = FormBuilder::begin()
            ->setId("f-" . (string)rand())
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

    public function testSubFormDefaultOnInvalid()
    {
        $requiredField = new Field([], [], 'text', 'A required field', "", true, []);
        $unrequiredField = new Field([], [], 'text', 'An unrequired field', "", false, []);

        $fields = ["required" => $requiredField, "unrequired" => $unrequiredField];

        $subForm = FormBuilder::begin()
            ->setId("f-" . (string)rand())
            ->addFields($fields)
            ->build();

        $form = FormBuilder::begin()
            ->setId("f-" . (string)rand())
            ->addSubForms([$subForm])
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

    public function testDefaultOnValid()
    {
        $unrequiredField = new Field([], [], 'text', 'An unrequired field', "", false, []);

        $fieldBearer = new MockFieldBearer();

        $form = FormBuilder::begin()
            ->setId("f-" . (string)rand())
            ->addFieldBearers([$fieldBearer])
            ->build();

        // Trigger the form's onInvalid method
        $form->onValid();

        // Assert that the input has been moved into the field's initial value
        $this->assertTrue($fieldBearer->saved);
    }

    public function testSubFormDefaultOnValid()
    {
        $unrequiredField = new Field([], [], 'text', 'An unrequired field', "", false, []);

        $fieldBearer = new MockFieldBearer();

        $subForm = FormBuilder::begin()
            ->setId("f-" . (string)rand())
            ->addFieldBearers([$fieldBearer])
            ->build();

        $form = FormBuilder::begin()
            ->setId("f-" . (string)rand())
            ->addSubForms([$subForm])
            ->build();

        // Trigger the form's onInvalid method
        $form->onValid();

        // Assert that the input has been moved into the field's initial value
        $this->assertTrue($fieldBearer->saved);
    }

    public function testOnvalidArgumentPassing()
    {
        $saveData = (string)rand();

        $fieldBearer = new MockFieldBearer();

        $subForm = FormBuilder::begin()
            ->setId("f-" . (string)rand())
            ->addFieldBearers([$fieldBearer])
            ->build();

        $form = FormBuilder::begin()
            ->setId("f-" . (string)rand())
            ->addSubForms([$subForm])
            ->build();

        // Trigger the form's onInvalid method
        $form->onValid($saveData);

        // Assert that the input has been moved into the field's initial value
        $this->assertEquals($saveData, $fieldBearer->savedData);
    }
}
