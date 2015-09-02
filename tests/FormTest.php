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

        $fieldBearer = FieldBearerBuilder::begin()
            ->addFields([new Field('literal', 'A literal field')])
            ->build();

        $form = FormBuilder::begin()
            ->setActions($actions)
            ->setFieldBearer($fieldBearer)
            ->setOnInvalidFunc($onInvalidFunc)
            ->setOnValidFunc($onValidFunc)
            ->build();

        $this->assertEquals($actions, $form->getActions());
        $this->assertEquals($fieldBearer, $form->getFieldBearer());

        $this->assertEquals("valid", $form->onValid());
        $this->assertEquals("invalid", $form->onInvalid());
    }

    public function testValidation() {

        $requiredField = new Field('required', 'A required field', "", true);
        $unrequiredField = new Field('unrequired', 'A required field', "", false);

        $fieldBearer = FieldBearerBuilder::begin()
            ->addFields(["required" => $requiredField, "unrequired" => $unrequiredField])
            ->build();

        /* Test endogenous field validation */
        $form = FormBuilder::begin()
            ->setFieldBearer($fieldBearer)
            ->build();

        // The required field has not been provided, the form should not be valid
        $this->assertFalse($form->isValid());

        $form = FormBuilder::begin()
            ->setFieldBearer($fieldBearer)
            ->build();
        $requiredField->removeErrors();

        // Provide input for the required field
        $_POST[$requiredField->getSlug()] = (string)rand();

        // The required field has been provided, the form should be valid.
        $this->assertTrue($form->isValid());
    }

    public function testInit() {

    }
}

