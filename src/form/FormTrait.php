<?php

namespace UWDOEM\Framework\Form;

use UWDOEM\Framework\FieldBearer\FieldBearerInterface;
use UWDOEM\Framework\Form\FormAction\FormAction;

trait FormTrait
{

    /** @var string */
    protected $id;

    /** @var bool */
    protected $isValid;

    /** @var string[] */
    protected $errors = [];

    /** @var FormAction[] */
    protected $actions;

    /** @var FieldBearerInterface  */
    protected $fieldBearer;

    /** @var callable */
    protected $onValidFunc;

    /** @var callable */
    protected $onInvalidFunc;

    /** @var array[]  */
    protected $validators;

    /** @var FormInterface[] */
    protected $subForms;


    public function getId()
    {
        return $this->id;
    }

    /**
     * @return FieldBearerInterface
     */
    public function getFieldBearer()
    {
        return $this->fieldBearer;
    }

    /**
     * @return mixed
     */
    public function onValid()
    {
        $args = array_merge([$this], func_get_args());
        return call_user_func_array($this->onValidFunc, $args);
    }

    /**
     * @return mixed
     */
    public function onInvalid()
    {
        $args = array_merge([$this], func_get_args());
        return call_user_func_array($this->onInvalidFunc, $args);
    }

    /**
     * @return boolean
     */
    public function isValid()
    {
        if (!isset($this->isValid)) {
            $this->validate();
        }
        return $this->isValid;
    }

    /**
     * @param string $error
     */
    public function addError($error)
    {
        $this->errors[] = $error;
    }

    /**
     * @return string[]
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @return FormAction[]
     */
    public function getActions()
    {
        return $this->actions;
    }

    /**
     * @return FormInterface[]
     */
    public function getSubForms()
    {
        return $this->subForms;
    }

    /**
     * @param string $name
     * @return FormInterface
     */
    public function getSubFormByName($name)
    {
        return $this->getSubForms()[$name];
    }


    public function propagateOnValid()
    {
        $args = array_merge([$this], func_get_args());

        $func = [$this->getFieldBearer(), "save"];
        call_user_func_array($func, $args);

        foreach ($this->getSubForms() as $subForm) {
            $func = [$subForm, "onValid"];
            call_user_func_array($func, $args);
        }
    }
}
