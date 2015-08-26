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

            $validatorName = "validate" . str_replace(".", "", ucfirst($name));
            if (method_exists(get_called_class(), $validatorName)) {
                call_user_func_array([$this, $validatorName], [$field]);
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
        if (is_callable($this->_onValidFunc)) {
            $args = array_merge([$this], func_get_args());
            return call_user_func_array($this->_onValidFunc, $args);
        }
    }

    /**
     * @return mixed
     */
    public function onInvalid() {
        if (is_callable($this->_onInvalidFunc)) {
            $args = array_merge([$this], func_get_args());
            return call_user_func_array($this->_onInvalidFunc, $args);
        }
    }

    /**
     * return null
     */
    protected function initFromPost() {
        $this->isValid() ? $this->onValid(): $this->onInvalid();
    }

    /**
     * return null
     */
    protected function initFromGet() {
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
     */
    public function __construct(
        FieldBearerInterface $fieldBearer,
        callable $onValidFunc,
        callable $onInvalidFunc,
        array $actions = []) {

        $this->_actions = $actions;
        $this->_fieldBearer = $fieldBearer;

        $this->_onInvalidFunc = $onInvalidFunc;
        $this->_onValidFunc = $onValidFunc;
    }
}