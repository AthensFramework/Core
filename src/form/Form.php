<?php

namespace UWDOEM\Framework\Form;

use UWDOEM\Framework\FieldBearer\FieldBearerInterface;
use UWDOEM\Framework\Form\FormAction\FormAction;
use UWDOEM\Framework\Visitor\VisitableTrait;


class Form implements FormInterface {

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

    use VisitableTrait;

    /**
     * @return FieldBearerInterface
     */
    public function getFieldBearer() {
        return $this->_fieldBearer;
    }

    /**
     * return null
     */
    protected function validate() {
        $this->_isValid = True;

        foreach ($this->getFieldBearer()->getFields() as $name => $field) {
            $field->validate();

            if (array_key_exists($name, $this->_validators)) {
                foreach($this->_validators[$name] as $validator) {
                    call_user_func_array($validator, [$field]);
                }
            }
        }

        foreach ($this->getFieldBearer()->getVisibleFields() as $name => $field) {
            if (!$field->isValid()) {
                $this->_isValid = False;
                break;
            }
        }
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
    protected function addError($error) {
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
     * @param FieldBearerInterface $fieldBearer
     * @param callable $onValidFunc
     * @param callable $onInvalidFunc
     * @param array $actions
     * @param array[] $validators
     */
    public function __construct(
        FieldBearerInterface $fieldBearer,
        callable $onValidFunc,
        callable $onInvalidFunc,
        array $actions = [],
        array $validators = [])
    {
        $this->_actions = $actions;
        $this->_fieldBearer = $fieldBearer;

        $this->_onInvalidFunc = $onInvalidFunc;
        $this->_onValidFunc = $onValidFunc;

        $this->_validators = $validators;
    }
}