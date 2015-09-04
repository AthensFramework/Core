<?php

namespace UWDOEM\Framework\Field;


class FieldBuilder {

    protected function __construct() {}

    /** @var bool  */
    protected $_required;

    /** @var int  */
    protected $_fieldSize;

    /** @var string */
    protected $_type;

    /** @var string */
    protected $_label;

    /** @var string|string[]  */
    protected $_initial;

    /** @var string[] */
    protected $_choices;

    /**
     * @return FieldBuilder
     */
    public static function begin() {
        return new static();
    }

    /**
     * @param boolean $required
     * @return FieldBuilder
     */
    public function setRequired($required) {
        $this->_required = $required;
        return $this;
    }

    /**
     * @param int $fieldSize
     * @return FieldBuilder
     */
    public function setFieldSize($fieldSize) {
        $this->_fieldSize = $fieldSize;
        return $this;
    }

    /**
     * @param string $type
     * @return FieldBuilder
     */
    public function setType($type) {
        $this->_type = $type;
        return $this;
    }

    /**
     * @param string $label
     * @return FieldBuilder
     */
    public function setLabel($label) {
        $this->_label = $label;
        return $this;
    }

    /**
     * @param string|string[] $initial
     * @return FieldBuilder
     */
    public function setInitial($initial) {
        $this->_initial = $initial;
        return $this;
    }

    /**
     * @param array $choices
     * @return FieldBuilder
     */
    public function setChoices($choices) {
        $this->_choices = $choices;
        return $this;
    }

    public function build() {
        if (!isset($this->_type)) {
            throw new \Exception("Must use ::setType to set a field type before building");
        }

        if (!isset($this->_label)) {
            throw new \Exception("Must use ::setLabel to set a field label before building");
        }

        if ($this->_type == Field::FIELD_TYPE_CHOICE || $this->_type == Field::FIELD_TYPE_MULTIPLE_CHOICE) {
            if (!isset($this->_choices)) {
                throw new \Exception("For the chosen field type, you must include choices using ::setChoices");
            }
        }

        return new Field(
            $this->_type,
            $this->_label,
            $this->_initial,
            $this->_required,
            $this->_choices,
            $this->_fieldSize
        );
    }
}