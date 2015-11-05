<?php

namespace UWDOEM\Framework\Form;

use UWDOEM\Framework\Form\FormAction\FormAction;


class PickAFormBuilder {

    protected $_manifest = [];

    protected $_actions = [];

    public function build() {
        return new PickAForm($this->_manifest, $this->_actions);
    }

    /**
     * @param string $label
     * @return PickAFormBuilder
     */
    public function addLabel($label) {
        $this->_manifest[$label] = null;
        return $this;
    }

    /**
     * @param FormInterface[] $forms
     * @return PickAFormBuilder
     */
    public function addForms(array $forms) {
        $this->_manifest = array_merge($this->_manifest, $forms);
        return $this;
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
     * @return PickAFormBuilder
     */
    public static function begin() {
        return new static();
    }
    
}