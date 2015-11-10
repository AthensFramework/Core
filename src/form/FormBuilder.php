<?php

namespace UWDOEM\Framework\Form;

use UWDOEM\Framework\Etc\AbstractBuilder;
use UWDOEM\Framework\Field\FieldBuilder;
use UWDOEM\Framework\Field\Field;


class FormBuilder extends AbstractBuilder {

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

        return $this->addFields([$labelField]);
    }

    /**
     * @return Form
     * @throws \Exception if setFieldBearer has not been called.
     */
    public function build() {

        $this->validateOnInvalidFunc();
        $this->validateOnValidFunc();
        $this->validateOnSuccessUrl();
        $this->validateActions();

        return new Form(
            $this->getFieldBearerBuilder()->build(),
            $this->_onValidFunc,
            $this->_onInvalidFunc,
            $this->_actions,
            $this->_subForms,
            $this->_validators
        );
    }
}