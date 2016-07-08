<?php

namespace Athens\Core\Form;

use Athens\Core\FieldBearer\FieldBearerBearerBuilderTrait;
use Athens\Core\Form\FormAction\FormAction;
use Athens\Core\Field\FieldBuilder;

trait FormBuilderTrait
{
    /** @var FormAction[] */
    protected $actions;

    /** @var string */
    protected $method = "post";

    /** @var string */
    protected $target = "_self";

    /** @var callable */
    protected $onValidFunc;

    /** @var callable */
    protected $onInvalidFunc;

    /** @var string */
    protected $onSuccessUrl;

    /** @var callable[] */
    protected $validators = [];

    /** @var FormInterface[] */
    protected $subForms = [];

    use FieldBearerBearerBuilderTrait;

    /**
     * @param FormAction[] $actions
     * @return $this
     */
    public function setActions(array $actions)
    {
        $this->actions = $actions;
        return $this;
    }

    /**
     * @param string $target
     * @return $this
     */
    public function setTarget($target)
    {
        $this->target = $target;
        return $this;
    }

    /**
     * @param string $method
     * @return $this
     */
    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @param callable $onValidFunc
     * @return $this
     */
    public function setOnValidFunc(callable $onValidFunc)
    {
        $this->onValidFunc = $onValidFunc;
        return $this;
    }

    /**
     * @param callable $onInvalidFunc
     * @return $this
     */
    public function setOnInvalidFunc(callable $onInvalidFunc)
    {
        $this->onInvalidFunc = $onInvalidFunc;
        return $this;
    }

    /**
     * @param string $onSuccessRedirect
     * @return $this
     */
    public function setOnSuccessUrl($onSuccessRedirect)
    {
        $this->onSuccessUrl = $onSuccessRedirect;
        return $this;
    }

    /**
     * @param FormInterface[] $subForms
     * @return FormBuilder
     */
    public function addSubForms(array $subForms)
    {
        $this->subForms = array_merge($this->subForms, $subForms);
        return $this;
    }

    /**
     * @param string   $fieldName
     * @param callable $callable
     * @return $this
     */
    public function addValidator($fieldName, callable $callable)
    {
        if (array_key_exists($fieldName, $this->validators) === false) {
            $this->validators[$fieldName] = [];
        }
        $this->validators[$fieldName][] = $callable;

        return $this;
    }

    /**
     * @return void
     */
    protected function validateOnInvalidFunc()
    {
        if ($this->onInvalidFunc === null) {
            $this->onInvalidFunc = function (FormInterface $thisForm) {
                foreach ($thisForm->getFieldBearer()->getFields() as $field) {
                    if ($field->getType() !== FieldBuilder::TYPE_LITERAL) {
                        $field->setInitial($field->getSubmitted());
                    }
                }

                foreach ($thisForm->getSubForms() as $subForm) {
                    $subForm->onInvalid();
                }
            };
        }
    }

    /**
     * @return void
     */
    protected function validateOnValidFunc()
    {
        if ($this->onValidFunc === null) {
            $this->onValidFunc = function (FormInterface $form) {
                $func = [$form, "propagateOnValid"];
                call_user_func_array($func, func_get_args());
            };
        }
    }

    /**
     * @return void
     */
    protected function validateOnSuccessUrl()
    {
        if ($this->onSuccessUrl !== null) {
            $onValidFunc = $this->onValidFunc;
            $url = $this->onSuccessUrl;

            $this->onValidFunc = function (FormInterface $form) use ($onValidFunc, $url) {
                if (headers_sent() === true) {
                    throw new \Exception("Form success redirection cannot proceed, output has already begun.");
                } else {
                    header("Location: $url");
                }

                $args = func_get_args();
                call_user_func_array($onValidFunc, $args);
            };
        }
    }

    /**
     * @return void
     */
    protected function validateActions()
    {
        if ($this->actions === null) {
            $this->actions = [new FormAction([], [], "Submit", "POST", ".")];
        }
    }
}
