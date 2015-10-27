<?php

namespace UWDOEM\Framework\Form;

use UWDOEM\Framework\FieldBearer\FieldBearerInterface;
use UWDOEM\Framework\Form\FormAction\FormAction;
use UWDOEM\Framework\FieldBearer\FieldBearerBuilder;
use UWDOEM\Framework\Field\Field;


class FormBuilder {

    /** @var FormAction[] */
    protected $_actions;

    /** @var callable */
    protected $_onValidFunc;

    /** @var callable */
    protected $_onInvalidFunc;

    /** @var FieldBearerBuilder */
    protected $_fieldBearerBuilder;

    /** @var string */
    protected $_onSuccessUrl;

    /** @var array[] */
    protected $_validators = [];

    /** @var FormInterface[] */
    protected $_subForms = [];


    protected function __construct() {
        $this->_fieldBearerBuilder = new FieldBearerBuilder();
    }

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
     * @param \Propel\Runtime\ActiveRecord\ActiveRecordInterface $object
     * @return FormBuilder
     */
    public function addObject($object) {
        $this->_fieldBearerBuilder->addObject($object);
        return $this;
    }

    /**
     * @param \UWDOEM\Framework\Field\FieldInterface[] $fields
     * @return FormBuilder
     */
    public function addFields(array $fields) {
        $this->_fieldBearerBuilder->addFields($fields);
        return $this;
    }

    /**
     * @param FieldBearerInterface[] $fieldBearers
     * @return FormBuilder
     */
    public function addFieldBearers(array $fieldBearers) {
        $this->_fieldBearerBuilder->addFieldBearers($fieldBearers);
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
     * @param string[] $visibleFieldNames
     * @return FormBuilder
     */
    public function setVisibleFieldNames(array $visibleFieldNames) {
        $this->_fieldBearerBuilder->setVisibleFieldNames($visibleFieldNames);
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
        $this->_fieldBearerBuilder = FieldBearerBuilder::begin();

        return $this;
    }

    /**
     * @return Form
     * @throws \Exception if setFieldBearer has not been called.
     */
    public function build() {
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

        if (!isset($this->_onValidFunc)) {
            $this->_onValidFunc = function(FormInterface $form) {
                $form->getFieldBearer()->save();

                foreach ($form->getSubForms() as $subForm) {
                    $subForm->onInvalid();
                }
            };
        }

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

        if (!isset($this->_actions)) {
            $this->_actions = [new FormAction("Submit", "POST", ".")];
        }

        return new Form(
            $this->_fieldBearerBuilder->build(),
            $this->_onValidFunc,
            $this->_onInvalidFunc,
            $this->_actions,
            $this->_subForms,
            $this->_validators
        );
    }
}