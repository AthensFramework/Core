<?php

namespace Athens\Core\Test;

use PHPUnit_Framework_TestCase;

use Athens\Core\Choice\ChoiceBuilder;
use Athens\Core\Form\FormBuilder;
use Athens\Core\FormAction\FormAction;
use Athens\Core\Field\Field;
use Athens\Core\WritableBearer\WritableBearerBuilder;
use Athens\Core\Field\FieldInterface;
use Athens\Core\Form\FormInterface;
use Athens\Core\Field\FieldBuilder;


class FormTest extends TestCase
{

    public function setUp()
    {
        $this->createORMFixtures();
    }

    /**
     * Basic tests for the Form builder classes.
     *
     * Any test here could potentially fail because of a failure in the constructed form.
     *
     * @throws \Exception
     */
    public function testBuilder()
    {

        $action = new FormAction([], [], "label", "method", "");

        $formFoundValid = false;
        $onValidFunc = function () use ($formFoundValid) {
            $formFoundValid = true;
        };

        $formFoundInvalid = false;
        $onInvalidFunc = function () use ($formFoundInvalid) {
            $formFoundInvalid = true;
        };

        $field = new Field([], [], 'literal', 'A literal field', []);
        $fieldName = "field";

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
            ->addAction($action)
            ->addWritable($field, $fieldName)
            ->addOnInvalidFunc($onInvalidFunc)
            ->addOnValidFunc($onValidFunc)
            ->build();

        $this->assertEquals([$action], $form->getActions());
        $this->assertContains($field, $form->getWritables());
        $this->assertEquals($id, $form->getId());
        $this->assertEquals($classes, $form->getClasses());
        $this->assertEquals($type, $form->getType());
        $this->assertEquals($method, $form->getMethod());
        $this->assertEquals($target, $form->getTarget());

        /* Test default type/method/target */
        $form = FormBuilder::begin()
            ->setId($id)
            ->build();

        $this->assertEquals("base", $form->getType());
        $this->assertEquals("post", $form->getMethod());
        $this->assertEquals("_self", $form->getTarget());

        $object = $this->instances[0];

        $form = FormBuilder::begin()->clear()
            ->setId("f-" . (string)rand())
            ->addObject($object)
            ->build();

        $expectedFieldNames = $object->getQualifiedPascalCasedColumnNames();
        $this->assertEquals($expectedFieldNames, array_keys($form->getWritables()));

        /* Test FormBuilder::addFieldBearer */
        $field = new Field([], [], 'literal', 'A literal field', []);

        $writableBearer = WritableBearerBuilder::begin()
            ->addWritable($field, "field")
            ->build();

        $form = FormBuilder::begin()
            ->setId("f-" . (string)rand())
            ->addWritableBearer($writableBearer)
            ->build();

        $this->assertContains("field", array_keys($form->getWritables()));

        /* Test FormBuilder::addSubForms */
        $field = new Field([], [], 'literal', 'A literal field', []);

        $writableBearer = WritableBearerBuilder::begin()
            ->addWritable($field, "field")
            ->build();

        $form1 = FormBuilder::begin()
            ->setId("f-" . (string)rand())
            ->addWritableBearer($writableBearer)
            ->build();

        $form2 = FormBuilder::begin()
            ->setId("f-" . (string)rand())
            ->addWritableBearer($writableBearer)
            ->build();

        $form = FormBuilder::begin()
            ->setId("f-" . (string)rand())
            ->addWritable($form1, "Form1")
            ->addWritable($form2, "Form2")
            ->build();

        $this->assertEquals(2, sizeof($form->getWritables()));
        $this->assertContains($form1, $form->getWritables());
        $this->assertContains($form2, $form->getWritables());
    }

    public function testLabelFieldCreation()
    {
        $labelText = (string)rand();

        $form = FormBuilder::begin()
            ->setId("f-" . (string)rand())
            ->addLabel($labelText)
            ->build();

        $labelField = array_values($form->getWritables())[0];

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
            ->addWritable(new Field([], [], 'literal', 'A literal field', []), "field")
            ->setOnSuccessUrl("http://example.com")
            ->build();

        $form->onValid();
    }
    
    public function testDefaultFormAction()
    {
        $form = FormBuilder::begin()
            ->setId("f-" . (string)rand())
            ->addWritable(new Field([], [], 'literal', 'A literal field', []), "field")
            ->build();

        $this->assertEquals(1, sizeof($form->getActions()));
        $this->assertEquals("submit", $form->getActions()[0]->getType());
        $this->assertEquals("Submit", $form->getActions()[0]->getLabel());
    }

    /**
     * Test can retrieve a subform by assigned name
     */
    public function testGetSubformByName()
    {
        $field = new Field([], [], 'literal', 'A literal field', []);

        $form1 = FormBuilder::begin()
            ->setId("f-" . (string)rand())
            ->addWritable($field, "field")
            ->build();

        $form2 = FormBuilder::begin()
            ->setId("f-" . (string)rand())
            ->addWritable($field)
            ->build();

        $form = FormBuilder::begin()
            ->setId("f-" . (string)rand())
            ->addWritable($form1, "Form1")
            ->addWritable($form2, "Form2")
            ->build();

        $this->assertEquals($form1, $form->getWritableBearer()->getWritableByHandle("Form1"));
        $this->assertEquals($form2, $form->getWritableBearer()->getWritableByHandle("Form2"));
    }

    public function testFormAddError()
    {
        $form = FormBuilder::begin()
            ->setId("f-" . (string)rand())
            ->addWritable(new Field([], [], 'literal', 'A literal field', []), "field")
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

        /* Do not provide input to the field which requires input */
        $form = FormBuilder::begin()
            ->setId("f-" . (string)rand())
            ->addWritable($requiredField, "required")
            ->addWritable($unrequiredField, "unrequired")
            ->build();

        // The required field has not been provided, the form should not be valid
        $this->assertFalse($form->isValid());

        /* Provide input to the field which requires input */
        $form = FormBuilder::begin()
            ->setId("f-" . (string)rand())
            ->addWritable($requiredField, "required")
            ->addWritable($unrequiredField, "unrequired")
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
            ->addWritable($specificField, "specific")
            ->addWritable($unrequiredField, "unrequired")
            ->addValidator("specific", $validator)
            ->build();

        // No input was provided, the form is not valid
        $this->assertFalse($form->isValid());


        /* Provide the wrong input to the specific field */
        $specificField->removeErrors();
        $form = FormBuilder::begin()
            ->setId("f-" . (string)rand())
            ->addWritable($specificField, "specific")
            ->addWritable($unrequiredField, "unrequired")
            ->addValidator("specific", $validator)
            ->build();

        $_POST[$specificField->getSlug()] = (string)rand();

        // Input was provided, but not the specific input required, form is not valid
        $this->assertFalse($form->isValid());


        /* Provide the correct input to the specific field */
        $specificField->removeErrors();
        $form = FormBuilder::begin()
            ->setId("f-" . (string)rand())
            ->addWritable($specificField, "specific")
            ->addWritable($unrequiredField, "unrequired")
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
            ->addWritable($field, "field")
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
            ->addWritable($requiredField, "required")
            ->addWritable($unrequiredField, "unrequired")
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

        $subForm = FormBuilder::begin()
            ->setId("f-" . (string)rand())
            ->addWritable($requiredField, "required")
            ->addWritable($unrequiredField, "unrequired")
            ->build();

        $form = FormBuilder::begin()
            ->setId("f-" . (string)rand())
            ->addWritable($subForm)
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

    public function testSetFieldAttributes()
    {
        $choices = [ChoiceBuilder::begin()->setValue('choice value')->build()];

        $form = FormBuilder::begin()
            ->setId("f-" . (string)rand())
            ->addWritable(new Field([], [], Field::TYPE_TEXT, 'A text field', []), "field")
            ->setFieldType("field", Field::TYPE_CHOICE)
            ->setFieldChoices("field", $choices)
            ->setInitialFieldValue("field", "new initial field value")
            ->setFieldLabel("field", "new field label")
            ->build();

        /** @var FieldInterface $field */
        $field = $form->getWritableBearer()->getWritableByHandle("field");

        $this->assertEquals(Field::TYPE_CHOICE, $field->getType());
        $this->assertEquals(array_values($choices), array_values($field->getChoices()));
        $this->assertEquals('new initial field value', $field->getInitial());
        $this->assertEquals('new field label', $field->getLabel());
    }

    public function testOnvalidArgumentPassing()
    {
//        $saveData = (string)rand();
//
//        $fieldBearer = new MockFieldBearer();
//
//        $subForm = FormBuilder::begin()
//            ->setId("f-" . (string)rand())
//            ->addWritableBearer([$fieldBearer])
//            ->build();
//
//        $form = FormBuilder::begin()
//            ->setId("f-" . (string)rand())
//            ->addSubForms([$subForm])
//            ->build();
//
//        // Trigger the form's onInvalid method
//        $form->onValid($saveData);
//
//        // Assert that the input has been moved into the field's initial value
//        $this->assertEquals($saveData, $fieldBearer->savedData);
    }
}
