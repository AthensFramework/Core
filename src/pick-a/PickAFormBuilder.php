<?php

namespace UWDOEM\Framework\PickA;

use UWDOEM\Framework\Etc\AbstractBuilder;
use UWDOEM\Framework\Form\FormAction\FormAction;

class PickAFormBuilder extends AbstractBuilder
{

    protected $manifest = [];

    protected $actions = [];


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
     * @param \UWDOEM\Framework\Form\FormInterface[] $forms
     * @return PickAFormBuilder
     */
    public function addForms(array $forms)
    {
        $this->manifest = array_merge($this->manifest, $forms);
        return $this;
    }

    /**
     * @param FormAction[] $actions
     * @return \UWDOEM\Framework\Form\FormBuilder
     */
    public function setActions($actions)
    {
        $this->actions = $actions;
        return $this;
    }

    /**
     * @return PickAFormInterface
     */
    public function build()
    {
        $this->validateId();

        return new PickAForm($this->id, $this->manifest, $this->actions);
    }
}
