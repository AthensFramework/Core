<?php

namespace UWDOEM\Framework\Form\FormAction;

use UWDOEM\Framework\Visitor\VisitableTrait;
use UWDOEM\Framework\Writer\WritableTrait;

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
    use WritableTrait;

    /**
     * @param string[] $classes
     * @param string   $label
     * @param string   $method
     * @param string   $target
     */
    public function __construct(array $classes, $label, $method, $target)
    {
        $this->label = $label;
        $this->method = $method;
        $this->target = $target;
        $this->classes = $classes;
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
