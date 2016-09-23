<?php

namespace Athens\Core\FormAction;

use Athens\Core\Writable\AbstractWritableBuilder;

/**
 * Class ChoiceBuilder
 *
 * @package Athens\Core\Choice
 */
class FormActionBuilder extends AbstractWritableBuilder implements FormActionConstantsInterface
{

    /** @var string */
    protected $label;
    
    /** @var string */
    protected $target;

    /** @var string */
    protected $type = FormActionConstantsInterface::TYPE_SUBMIT;
    
    /**
     * @param string $label
     * @return $this
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @param string $target
     * @return $this
     */
    public function setTarget($target)
    {
        $this->target = $target;
        return $this;
    }
    
    /**
     * @return FormActionInterface
     * @throws \Exception If the correct settings have not been provided.
     */
    public function build()
    {

        return new FormAction($this->classes, $this->data, $this->type, $this->label, $this->target);
    }
}
