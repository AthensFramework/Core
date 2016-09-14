<?php

namespace Athens\Core\Form;

use Athens\Core\WritableBearer\WritableBearerInterface;
use Athens\Core\Form\FormAction\FormAction;
use Athens\Core\Writable\WritableTrait;

trait FormTrait
{
    use WritableTrait;

    /** @var string */
    protected $method;

    /** @var string */
    protected $target;

    /** @var bool */
    protected $isValid;

    /** @var string[] */
    protected $errors = [];

    /** @var FormAction[] */
    protected $actions;

    /** @var WritableBearerInterface  */
    protected $writableBearer;

    /** @var callable */
    protected $onValidFunc;

    /** @var callable */
    protected $onInvalidFunc;

    /** @var array[]  */
    protected $validators;

    /** @return void */
    protected abstract function validate();

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * @return WritableBearerInterface
     */
    public function getWritableBearer()
    {
        return $this->writableBearer;
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
        if ($this->isValid === null) {
            $this->validate();
        }
        return $this->isValid;
    }

    /**
     * @param string $error
     * @return void
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
     * @param string $name
     * @return FormInterface
     */
    public function getSubFormByName($name)
    {
        return $this->getSubForms()[$name];
    }

    /**
     * @return void
     */
    public function propagateOnValid()
    {
        $args = array_merge([$this], func_get_args());

        foreach ($this->getSubForms() as $subForm) {
            $func = [$subForm, "onValid"];
            call_user_func_array($func, $args);
        }
    }
}
