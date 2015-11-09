<?php

namespace UWDOEM\Framework\Table;

use UWDOEM\Framework\Etc\AbstractBuilder;
use UWDOEM\Framework\Field\Field;
use UWDOEM\Framework\Row\RowBuilder;
use UWDOEM\Framework\Form\FormBuilderTrait;


class TableFormBuilder extends AbstractBuilder {

    use FormBuilderTrait;

    /** @var RowBuilder */
    protected $_rowBuilder;


    /**
     * @param RowBuilder $rowBuilder
     * @return TableFormBuilder
     */
    public function setRowBuilder($rowBuilder) {
        $this->_rowBuilder = $rowBuilder;
        return $this;
    }

    protected function validateOnInvalidFunc() {
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
    }

    protected function validateOnValidFunc() {
        if (!isset($this->_onValidFunc)) {
            $this->_onValidFunc = function(TableFormInterface $form) {
                foreach ($form->getRows() as $row) {
                    $row->getFieldBearer()->save();
                }
            };
        }
    }
    
    /**
     * @return TableForm
     */
    public function build() {

        $this->validateOnInvalidFunc();
        $this->validateOnValidFunc();
        $this->validateOnSuccessUrl();
        $this->validateActions();

        return new TableForm(
            $this->_rowBuilder,
            $this->_onValidFunc,
            $this->_onInvalidFunc,
            $this->_actions,
            $this->_validators
        );
    }
}