<?php

namespace UWDOEM\Framework\Form;

use UWDOEM\Framework\FieldBearer\FieldBearerBearerBuilderTrait;
use UWDOEM\Framework\Form\FormAction\FormAction;
use UWDOEM\Framework\Field\Field;


trait FormBuilderTrait {

    /** @var FormAction[] */
    protected $_actions;

    /** @var callable */
    protected $_onValidFunc;

    /** @var callable */
    protected $_onInvalidFunc;

    /** @var string */
    protected $_onSuccessUrl;

    /** @var callable[] */
    protected $_validators = [];

    /** @var FormInterface[] */
    protected $_subForms = [];

    use FieldBearerBearerBuilderTrait;


    /**
     * @param FormAction[] $actions
     * @return $this
     */
    public function setActions($actions) {
        $this->_actions = $actions;
        return $this;
    }

    /**
     * @param callable $onValidFunc
     * @return $this
     */
    public function setOnValidFunc($onValidFunc) {
        $this->_onValidFunc = $onValidFunc;
        return $this;
    }

    /**
     * @param callable $onInvalidFunc
     * @return $this
     */
    public function setOnInvalidFunc($onInvalidFunc) {
        $this->_onInvalidFunc = $onInvalidFunc;
        return $this;
    }

    /**
     * @param string $onSuccessRedirect
     * @return $this
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
     * @return $this
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
                $args = array_merge([$form], func_get_args());

                $func = [$form->getFieldBearer(), "save"];
                call_user_func_array($func, $args);

                foreach ($form->getSubForms() as $subForm) {
                    $func = [$subForm, "onValid"];
                    call_user_func_array($func, $args);
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

}