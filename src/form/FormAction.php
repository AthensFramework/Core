<?php

namespace UWDOEM\Framework\Form\FormAction;

use UWDOEM\Framework\Visitor\VisitableTrait;


class FormAction implements FormActionInterface {

    protected $_label;
    protected $_method;
    protected $_target;

    use VisitableTrait;

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