<?php

namespace UWDOEM\Framework\Form;

use UWDOEM\Framework\Form\FormAction\FormAction;
use UWDOEM\Framework\FieldBearer\FieldBearerInterface;


class FormBuilder {

    /**
     * @var FormAction[]
     */
    protected $_actions;

    /**
     * @var callable
     */
    protected $_onValidFunc;

    /**
     * @var callable
     */
    protected $_onInvalidFunc;

    /**
     * @var FieldBearerInterface
     */
    protected $_fieldBearer;

    /**
     * @param FormAction[] $actions
     * @return FormBuilder
     */
    public function setActions($actions) {
        $this->_actions = $actions;
        return $this;
    }

    /**
     * @param callable $onValidFunc
     * @return FormBuilder
     */
    public function setOnValidFunc($onValidFunc) {
        $this->_onValidFunc = $onValidFunc;
        return $this;
    }

    /**
     * @param callable $onInvalidFunc
     * @return FormBuilder
     */
    public function setOnInvalidFunc($onInvalidFunc) {
        $this->_onInvalidFunc = $onInvalidFunc;
        return $this;
    }

    /**
     * @param FieldBearerInterface $fieldBearer
     * @return FormBuilder
     */
    public function setFieldBearer($fieldBearer) {
        $this->_fieldBearer = $fieldBearer;
        return $this;
    }

    /**
     * @return FormBuilder
     */
    public static function begin() {
        return new static();
    }

    /**
     * @return FormBuilder
     */
    public function clear() {
        $this->_actions = null;
        $this->_onValidFunc = null;
        $this->_onInvalidFunc = null;
        $this->_fieldBearer = null;

        return $this;
    }

    /**
     * @return Form
     * @throws \Exception if setFieldBearer has not been called.
     */
    public function build() {
        if (!$this->_fieldBearer) {
            throw new \Exception("Must make fieldBearer before calling this method.");
        }

        if (!isset($this->_onInvalidFunc)) {

            $this->_onInvalidFunc = function (FormInterface $thisForm) {
                foreach ($thisForm->getFieldBearer()->getFields() as $field) {
                    if (array_key_exists($field->getSlug(), $_POST) && $field->getType() !== "literal") {
                        $field->setInitial($_POST[$field->getSlug()]);
                    }
                }
            };

        }

        if (!isset($this->_onValidFunc)) {
            $this->_onValidFunc = function() {};
        }

        return new Form(
            $this->_fieldBearer,
            $this->_onValidFunc,
            $this->_onInvalidFunc,
            $this->_actions
        );
    }


//    protected function makeActions() {
//        return [
//            new FormAction("Submit", "POST", "."),
//        ];
//    }

}