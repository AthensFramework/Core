<?php

namespace UWDOEM\Framework\Form;

use UWDOEM\Framework\Etc\AbstractBuilder;
use UWDOEM\Framework\Field\FieldBuilder;
use UWDOEM\Framework\Field\Field;


class FormBuilder extends AbstractBuilder {

    /** @var string */
    protected $_id;

    use FormBuilderTrait;


    /**
     * @param string $label
     * @return FormBuilder
     */
    public function addLabel($label) {
        $labelField = FieldBuilder::begin()
            ->setType(Field::FIELD_TYPE_SECTION_LABEL)
            ->setLabel($label)
            ->build();

        return $this->addFields([$label => $labelField]);
    }

    /**
     * @param string $id
     * @return FormBuilder
     */
    public function setId($id) {
        $this->_id = $id;
        return $this;
    }

    /**
     * @return Form
     * @throws \Exception if setFieldBearer has not been called.
     */
    public function build() {

        if (!isset($this->_id)) {
            throw new \RuntimeException("Must use ::setId to provide a form id before calling this method.");
        }

        $this->validateOnInvalidFunc();
        $this->validateOnValidFunc();
        $this->validateOnSuccessUrl();
        $this->validateActions();

        return new Form(
            $this->_id, $this->buildFieldBearer(), $this->_onValidFunc, $this->_onInvalidFunc, $this->_actions, $this->_subForms, $this->_validators
        );
    }
}