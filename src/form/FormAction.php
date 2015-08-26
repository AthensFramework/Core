<?php

namespace UWDOEM\Framework\Form\FormAction;


class FormAction {

    protected $_label;
    protected $_method;
    protected $_target;

    public function __construct($label, $method, $target) {
        $this->_label = $label;
        $this->_method = $method;
        $this->_target = $target;
    }

    public function getMethod() {
        return $this->_method;
    }
    
    public function getTarget() {
        return $this->_target;
    }

    public function getLabel() {
        return $this->_label;
    }
}