<?php

namespace UWDOEM\Framework\Form;

use UWDOEM\Framework\FieldBearer\FieldBearerInterface;
use UWDOEM\Framework\Form\FormAction\FormAction;


trait FormTrait {

    /** @var bool */
    protected $_isValid;

    /** @var string[] */
    protected $_formErrors = [];

    /** @var FormAction[] */
    protected $_actions;

    /** @var FieldBearerInterface  */
    protected $_fieldBearer;

    /** @var callable */
    protected $_onValidFunc;

    /** @var callable */
    protected $_onInvalidFunc;

    /** @var array[]  */
    protected $_validators;

    /** @var FormInterface[] */
    protected $_subForms;


    /**
     * @return FieldBearerInterface
     */
    public function getFieldBearer() {
        return $this->_fieldBearer;
    }

    /**
     * @return mixed
     */
    public function onValid() {
        $args = array_merge([$this], func_get_args());
        return call_user_func_array($this->_onValidFunc, $args);
    }

    /**
     * @return mixed
     */
    public function onInvalid() {
        $args = array_merge([$this], func_get_args());
        return call_user_func_array($this->_onInvalidFunc, $args);
    }

    /**
     * @return bool
     */
    public function isValid() {
        if (!isset($this->_isValid)) {
            $this->validate();
        }
        return $this->_isValid;
    }

    /**
     * @param string $error
     */
    public function addError($error) {
        $this->_formErrors[] = $error;
    }

    /**
     * @return string[]
     */
    public function getErrors() {
        return $this->_formErrors;
    }

    /**
     * @return FormAction[]
     */
    public function getActions() {
        return $this->_actions;
    }

    /**
     * @return FormInterface[]
     */
    public function getSubForms() {
        return $this->_subForms;
    }

    /**
     * @param string $name
     * @return FormInterface
     */
    public function getSubFormByName($name) {
        return $this->getSubForms()[$name];
    }

}