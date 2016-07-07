<?php

namespace Athens\Core\PickA;

use Athens\Core\Form\FormAction\FormAction;
use Athens\Core\Form\FormAction\FormActionInterface;
use Athens\Core\Writable\AbstractWritableBuilder;

/**
 * Class PickAFormBuilder
 *
 * @package Athens\Core\PickA
 */
class PickAFormBuilder extends AbstractWritableBuilder
{
    /** @var string */
    protected $type = "base";

    /** @var string */
    protected $method = "post";

    /** @var string */
    protected $target = "_self";

    /** @var array */
    protected $manifest = [];

    /** @var FormActionInterface[] */
    protected $actions = [];

    /**
     * @param string $method
     * @return PickAFormBuilder
     */
    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @param string $target
     * @return PickAFormBuilder
     */
    public function setTarget($target)
    {
        $this->target = $target;
        return $this;
    }

    /**
     * @param string $label
     * @return PickAFormBuilder
     */
    public function addLabel($label)
    {
        $this->manifest[$label] = null;
        return $this;
    }

    /**
     * @param \Athens\Core\Form\FormInterface[] $forms
     * @return PickAFormBuilder
     */
    public function addForms(array $forms)
    {
        $this->manifest = array_merge($this->manifest, $forms);
        return $this;
    }

    /**
     * @param FormActionInterface[] $actions
     * @return PickAFormBuilder
     */
    public function setActions(array $actions)
    {
        $this->actions = $actions;
        return $this;
    }

    /**
     * @param string $type
     * @return PickAFormBuilder
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return PickAFormInterface
     */
    public function build()
    {
        $this->validateId();

        return new PickAForm(
            $this->id,
            $this->classes,
            $this->data,
            $this->type,
            $this->method,
            $this->target,
            $this->manifest,
            $this->actions
        );
    }
}
