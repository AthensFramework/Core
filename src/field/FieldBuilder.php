<?php

namespace Athens\Core\Field;

use Athens\Core\Choice\ChoiceInterface;
use Athens\Core\Etc\AbstractBuilder;

/**
 * Class FieldBuilder
 *
 * @package Athens\Core\Field
 */
class FieldBuilder extends AbstractBuilder implements FieldConstantsInterface
{

    /** @var bool  */
    protected $required;

    /** @var int  */
    protected $fieldSize;

    /** @var string */
    protected $type;

    /** @var string */
    protected $label;

    /** @var mixed|mixed[]  */
    protected $initial;

    /** @var ChoiceInterface[] */
    protected $choices = [];

    /** @var string */
    protected $helptext = "";

    /** @var string */
    protected $placeholder = "";

    /**
     * @param boolean $required
     * @return FieldBuilder
     */
    public function setRequired($required)
    {
        $this->required = $required;
        return $this;
    }

    /**
     * @param integer $fieldSize
     * @return FieldBuilder
     */
    public function setFieldSize($fieldSize)
    {
        $this->fieldSize = $fieldSize;
        return $this;
    }

    /**
     * @param string $type
     * @return FieldBuilder
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @param string $label
     * @return FieldBuilder
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @param string|string[] $initial
     * @return FieldBuilder
     */
    public function setInitial($initial)
    {
        $this->initial = $initial;
        return $this;
    }

    /**
     * @param ChoiceInterface[] $choices
     * @return FieldBuilder
     */
    public function setChoices(array $choices)
    {
        $this->choices = $choices;
        return $this;
    }

    /**
     * @param string $helptext
     * @return FieldBuilder
     */
    public function setHelptext($helptext)
    {
        $this->helptext = $helptext;
        return $this;
    }

    /**
     * @param string $placeholder
     * @return FieldBuilder
     */
    public function setPlaceholder($placeholder)
    {
        $this->placeholder = $placeholder;
        return $this;
    }

    /**
     * @return Field
     * @throws \Exception If the correct settings have not been provided.
     */
    public function build()
    {
        if ($this->type === null) {
            throw new \Exception("Must use ::setType to set a field type before building");
        }

        if ($this->label === null) {
            throw new \Exception("Must use ::setLabel to set a field label before building");
        }

        if ($this->type === static::TYPE_CHOICE || $this->type === static::TYPE_MULTIPLE_CHOICE) {
            if ($this->choices === []) {
                throw new \Exception("For the chosen field type, you must include choices using ::setChoices");
            }
        }

        return new Field(
            $this->classes,
            $this->data,
            $this->type,
            $this->label,
            $this->initial,
            $this->required,
            $this->choices,
            $this->fieldSize,
            $this->helptext,
            $this->placeholder
        );
    }
}
