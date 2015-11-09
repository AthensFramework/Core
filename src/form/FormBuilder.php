<?php

namespace UWDOEM\Framework\Form;

use UWDOEM\Framework\Etc\AbstractBuilder;


class FormBuilder extends AbstractBuilder {

    use FormBuilderTrait;


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