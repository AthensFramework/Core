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
            ->setFields([new Field('literal', 'A literal field')])
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
}

