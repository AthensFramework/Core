<?php

namespace Athens\Core\FormAction;

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
    protected $target;

    use VisitableTrait;
    use WritableTrait;

    /**
     * @param string[] $classes
     * @param array    $data
     * @param string   $type
     * @param string   $label
     * @param string   $target
     */
    public function __construct(array $classes, array $data, $type, $label, $target)
    {
        $this->label = $label;
        $this->type = $type;
        $this->target = $target;
        $this->classes = $classes;
        $this->data = $data;
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
