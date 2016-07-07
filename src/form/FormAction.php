<?php

namespace Athens\Core\Form\FormAction;

use Athens\Core\Visitor\VisitableTrait;
use Athens\Core\Writable\WritableTrait;

/**
 * Class FormAction
 *
 * @package Athens\Core\Form\FormAction
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
     * @param array    $data
     * @param string   $label
     * @param string   $method
     * @param string   $target
     */
    public function __construct(array $classes, array $data, $label, $method, $target)
    {
        $this->label = $label;
        $this->method = $method;
        $this->target = $target;
        $this->classes = $classes;
        $this->data = $data;
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
