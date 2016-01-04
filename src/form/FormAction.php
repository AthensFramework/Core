<?php

namespace UWDOEM\Framework\Form\FormAction;

use UWDOEM\Framework\Visitor\VisitableTrait;

/**
 * Class FormAction
 *
 * @package UWDOEM\Framework\Form\FormAction
 */
class FormAction implements FormActionInterface
{

    /** @var string */
    protected $label;

    /** @var string */
    protected $method;

    /** @var string */
    protected $target;

    use VisitableTrait;

    /**
     * @return string
     */
    public function getId()
    {
        return md5($this->getLabel() . $this->getMethod() . $this->getTarget());
    }

    /**
     * @param string $label
     * @param string $method
     * @param string $target
     */
    public function __construct($label, $method, $target)
    {
        $this->label = $label;
        $this->method = $method;
        $this->target = $target;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }
}
