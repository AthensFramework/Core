<?php

namespace UWDOEM\Framework\Table;

use UWDOEM\Framework\Form\FormAction\FormAction;
use UWDOEM\Framework\Field\Field;
use UWDOEM\Framework\Row\RowInterface;
use UWDOEM\Framework\Row\RowBuilder;
use UWDOEM\Framework\Form\FormInterface;


class TableFormBuilder {

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

    /** @var RowInterface */
    protected $_rowBuilder;


    /**
     * @param RowBuilder $rowBuilder
     * @return TableFormBuilder
     */
    public function setRowBuilder($rowBuilder) {
        $this->_rowBuilder = $rowBuilder;
        return $this;
    }

    /**
     * @param FormAction[] $actions
     * @return TableFormBuilder
     */
    public function setActions($actions) {
        $this->_actions = $actions;
        return $this;
    }

    /**
     * @param callable $onValidFunc
     * @return TableFormBuilder
     */
    public function setOnValidFunc($onValidFunc) {
        $this->_onValidFunc = $onValidFunc;
        return $this;
    }

    /**
     * @param callable $onInvalidFunc
     * @return TableFormBuilder
     */
    public function setOnInvalidFunc($onInvalidFunc) {
        $this->_onInvalidFunc = $onInvalidFunc;
        return $this;
    }

    /**
     * @param string $onSuccessRedirect
     * @return TableFormBuilder
     */
    public function setOnSuccessUrl($onSuccessRedirect) {
        $this->_onSuccessUrl = $onSuccessRedirect;
        return $this;
    }

    /**
     * @param string $fieldName
     * @param callable $callable
     * @return TableFormBuilder
     */
    public function addValidator($fieldName, callable $callable) {
        if (!array_key_exists($fieldName, $this->_validators)) {
            $this->_validators[$fieldName] = [];
        }
        $this->_validators[$fieldName][] = $callable;

        return $this;
    }

    /**
     * @return TableFormBuilder
     */
    public static function begin() {
        return new static();
    }

    /**
     * @return TableForm
     */
    public function build() {
        if (!isset($this->_onInvalidFunc)) {

            $this->_onInvalidFunc = function (TableFormInterface $thisForm) {
                $this->_onValidFunc = function(TableFormInterface $form) {
                    foreach ($form->getRows() as $row) {
                        foreach ($row->getFieldBearer()->getFields() as $field) {
                            if ($field->getType() !== Field::FIELD_TYPE_LITERAL) {
                                $field->setInitial($field->getSubmitted());
                            }
                        }
                    }
                };

            };
        }

        if (!isset($this->_onValidFunc)) {
            $this->_onValidFunc = function(TableFormInterface $form) {
                foreach ($form->getRows() as $row) {
                    $row->getFieldBearer()->save();
                }
            };
        }

        if(isset($this->_onSuccessUrl)) {

            $onValidFunc = $this->_onValidFunc;
            $url = $this->_onSuccessUrl;

            $this->_onValidFunc = function(TableFormInterface $form) use ($onValidFunc, $url) {
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

        return new TableForm(
            $this->_rowBuilder,
            $this->_onValidFunc,
            $this->_onInvalidFunc,
            $this->_actions,
            $this->_validators
        );
    }
}