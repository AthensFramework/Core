<?php

namespace UWDOEM\Framework\Form;

use UWDOEM\Framework\FieldBearer\FieldBearerBearerBuilderTrait;
use UWDOEM\Framework\Form\FormAction\FormAction;
use UWDOEM\Framework\Field\Field;

trait FormBuilderTrait
{

    /** @var FormAction[] */
    protected $actions;

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
    public function setActions($actions)
    {
        $this->actions = $actions;
        return $this;
    }

    /**
     * @param callable $onValidFunc
     * @return $this
     */
    public function setOnValidFunc($onValidFunc)
    {
        $this->onValidFunc = $onValidFunc;
        return $this;
    }

    /**
     * @param callable $onInvalidFunc
     * @return $this
     */
    public function setOnInvalidFunc($onInvalidFunc)
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
        if (!array_key_exists($fieldName, $this->validators)) {
            $this->validators[$fieldName] = [];
        }
        $this->validators[$fieldName][] = $callable;

        return $this;
    }

    protected function validateOnInvalidFunc()
    {
        if (!isset($this->onInvalidFunc)) {

            $this->onInvalidFunc = function (FormInterface $thisForm) {
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

    protected function validateOnValidFunc()
    {
        if (!isset($this->onValidFunc)) {

            $this->onValidFunc = function (FormInterface $form) {
                $func = [$form, "propagateOnValid"];
                call_user_func_array($func, func_get_args());
            };

        }
    }

    protected function validateOnSuccessUrl()
    {
        if (isset($this->onSuccessUrl)) {

            $onValidFunc = $this->onValidFunc;
            $url = $this->onSuccessUrl;

            $this->onValidFunc = function (FormInterface $form) use ($onValidFunc, $url) {
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

    protected function validateActions()
    {
        if (!isset($this->actions)) {
            $this->actions = [new FormAction("Submit", "POST", ".")];
        }
    }
}
