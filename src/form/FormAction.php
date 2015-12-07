<?php

namespace UWDOEM\Framework\Form\FormAction;

use UWDOEM\Framework\Visitor\VisitableTrait;

class FormAction implements FormActionInterface
{

    protected $label;

    protected $method;

    protected $target;

    use VisitableTrait;


    public function getId()
    {
        return md5($this->getLabel() . $this->getMethod() . $this->getTarget());
    }

    public function __construct($label, $method, $target)
    {
        $this->label = $label;
        $this->method = $method;
        $this->target = $target;
    }

    public function getMethod()
    {
        return $this->method;
    }
    
    public function getTarget()
    {
        return $this->target;
    }

    public function getLabel()
    {
        return $this->label;
    }
}
