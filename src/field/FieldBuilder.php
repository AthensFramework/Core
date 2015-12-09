<?php

namespace UWDOEM\Framework\Field;

use UWDOEM\Framework\Etc\AbstractBuilder;

/**
 * Class FieldBuilder
 *
 * @package UWDOEM\Framework\Field
 */
class FieldBuilder extends AbstractBuilder
{

    /** @var bool  */
    protected $required;

    /** @var int  */
    protected $fieldSize;

    /** @var string */
    protected $type;

    /** @var string */
    protected $label;

    /** @var string|string[]  */
    protected $initial;

    /** @var string[] */
    protected $choices;


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
     * @param array $choices
     * @return FieldBuilder
     */
    public function setChoices($choices)
    {
        $this->choices = $choices;
        return $this;
    }

    public function build()
    {
        if (!isset($this->type)) {
            throw new \Exception("Must use ::setType to set a field type before building");
        }

        if (!isset($this->label)) {
            throw new \Exception("Must use ::setLabel to set a field label before building");
        }

        if ($this->type == Field::FIELD_TYPE_CHOICE || $this->type == Field::FIELD_TYPE_MULTIPLE_CHOICE) {
            if (!isset($this->choices)) {
                throw new \Exception("For the chosen field type, you must include choices using ::setChoices");
            }
        }

        return new Field(
            $this->type,
            $this->label,
            $this->initial,
            $this->required,
            $this->choices,
            $this->fieldSize
        );
    }
}
