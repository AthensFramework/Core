<?php


use UWDOEM\Framework\Form\FormBuilder;
use UWDOEM\Framework\Form\FormAction\FormAction;
use UWDOEM\Framework\Field\Field;
use UWDOEM\Framework\FieldBearer\FieldBearerBuilder;


class FormTest extends PHPUnit_Framework_TestCase {

    /**
     * @return FormBuilder[]
     */
    public function testedFormBuilders() {
        // Return a fieldBearerBuilder of every type you want to test
        return [
            FormBuilder::begin(),
        ];
    }

    /**
     * Basic tests for the Form builder classes.
     *
     * Any test here could potentially fail because of a failure in the constructed form.
     *
     * @throws \Exception
     */
    public function testBuilder() {

        $actions = [new FormAction("label", "method", "")];
        $onValidFunc = function() { return "valid"; };
        $onInvalidFunc = function() { return "invalid"; };

        $fields = [new Field('literal', 'A literal field', [])];

        $form = FormBuilder::begin()
            ->setActions($actions)
            ->addFields($fields)
            ->setOnInvalidFunc($onInvalidFunc)
            ->setOnValidFunc($onValidFunc)
            ->build();

        $this->assertEquals($actions, $form->getActions());
        $this->assertContains($fields[0], $form->getFieldBearer()->getFields());
        $this->assertEquals(1, sizeof($form->getFieldBearer()->getFields()));

        $this->assertEquals("valid", $form->onValid());
        $this->assertEquals("invalid", $form->onInvalid());
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
        $unrequiredField = new Field('text', 'A required field', "", false, []);
        $specificField = new Field("text", "A field which required specific input.", []);
        $fields = ["specific" => $specificField, "unrequired" => $unrequiredField];

        $requiredInput = "the specific input required";

        $validator = function(\UWDOEM\Framework\Field\FieldInterface $field) use ($requiredInput) {
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

    public function testInit() {

    }
}

