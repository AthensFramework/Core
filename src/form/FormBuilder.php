<?php

namespace UWDOEM\Framework\Form;

use UWDOEM\Framework\Etc\AbstractBuilder;
use UWDOEM\Framework\FieldBearer\FieldBearerBearerBuilderTrait;
use UWDOEM\Framework\Form\FormAction\FormAction;
use UWDOEM\Framework\Field\Field;


class FormBuilder extends AbstractBuilder {

    /** @var FormAction[] */
    protected $_actions;

    /** @var callable */
    protected $_onValidFunc;

    /** @var callable */
    protected $_onInvalidFunc;

    /** @var string */
    protected $_onSuccessUrl;

    /** @var array[] */
    protected $_validators = [];

    /** @var FormInterface[] */
    protected $_subForms = [];

    use FieldBearerBearerBuilderTrait;


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
     * @param string $onSuccessRedirect
     * @return FormBuilder
     */
    public function setOnSuccessUrl($onSuccessRedirect) {
        $this->_onSuccessUrl = $onSuccessRedirect;
        return $this;
    }

    /**
     * @param FormInterface[] $subForms
     * @return FormBuilder
     */
    public function addSubForms(array $subForms) {
    $this->_subForms = array_merge($this->_subForms, $subForms);
    return $this;
    }



    /**
     * @param string $fieldName
     * @param callable $callable
     * @return FormBuilder
     */
    public function addValidator($fieldName, callable $callable) {
        if (!array_key_exists($fieldName, $this->_validators)) {
            $this->_validators[$fieldName] = [];
        }
        $this->_validators[$fieldName][] = $callable;

        return $this;
    }

    protected function validateOnInvalidFunc() {
        if (!isset($this->_onInvalidFunc)) {

            $this->_onInvalidFunc = function (FormInterface $thisForm) {
                foreach ($thisForm->getFieldBearer()->getFields() as $field) {

                    if ($field->getType() !== Field::FIELD_TYPE_LITERAL) {
                        $field->setInitial($field->getSubmitted());
                    }
                }

                foreach ($thisForm->getSubForms() as $subForm) {
                    $subForm->onInvalid();
                }
            };

        }
    }

    protected function validateOnValidFunc() {
        if (!isset($this->_onValidFunc)) {

            $this->_onValidFunc = function(FormInterface $form) {
                $form->getFieldBearer()->save();

                foreach ($form->getSubForms() as $subForm) {
                    $subForm->onValid();
                }
            };

        }
    }

    protected function validateOnSuccessUrl() {
        if(isset($this->_onSuccessUrl)) {

            $onValidFunc = $this->_onValidFunc;
            $url = $this->_onSuccessUrl;

            $this->_onValidFunc = function(FormInterface $form) use ($onValidFunc, $url) {
                if (headers_sent()) {
                    throw new \Exception("Form success redirection cannot proceed, output has already begun.");
                } else {
                    header("Location: $url");
                }

                $args = func_get_args();
                call_user_func_array($onValidFunc, $args);
            };
        }
    }

    protected function validateActions() {
        if (!isset($this->_actions)) {
            $this->_actions = [new FormAction("Submit", "POST", ".")];
        }
    }

    /**
     * @return Form
     * @throws \Exception if setFieldBearer has not been called.
     */
    public function build() {

        $this->validateOnInvalidFunc();
        $this->validateOnValidFunc();
        $this->validateOnSuccessUrl();
        $this->validateActions();
        
        return new Form(
            $this->getFieldBearerBuilder()->build(),
            $this->_onValidFunc,
            $this->_onInvalidFunc,
            $this->_actions,
            $this->_subForms,
            $this->_validators
        );
    }
}