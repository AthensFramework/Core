<?php

namespace UWDOEM\Framework\Field;

use UWDOEM\Framework\Etc\StringUtils;
use UWDOEM\Framework\Visitor\VisitableTrait;


class Field implements FieldInterface {

    /** @var bool  */
    protected $_required;

    /** @var int  */
    protected $_fieldSize;

    /** @var string */
    protected $_type;

    /** @var string */
    protected $_label;

    /** @var string  */
    protected $_initial;

    /** @var string[] */
    protected $_fieldErrors = [];

    /** @var string[] */
    protected $_prefixes = [];

    /** @var string[] */
    protected $_suffixes = [];

    /** @var string */
    protected $_validatedData;

    /** @var bool */
    protected $_isValid;

    /** @var array */
    protected $_choices;


    use VisitableTrait;

    /**
     * @param string $type
     * @param string $label
     * @param string|null $initial
     * @param bool|False $required
     * @param $choices
     * @param int $fieldSize
     */
    function __construct($type, $label = "", $initial = "", $required = False, $choices = [], $fieldSize = 255) {
        $this->_type = $type;
        $this->_label = $label;
        $this->_initial = $initial;
        $this->_required = $required;
        $this->_choices = $choices;
        $this->_fieldSize = $fieldSize;
    }

    /**
     * @return string
     */
    public function getSubmitted() {
        if ($this->getType() == "checkbox") {
            return (string)array_key_exists($this->getSlug(), $_POST);
        } else {
            return array_key_exists($this->getSlug(), $_POST) ? $_POST[$this->getSlug()]: "";
        }
    }

    /**
     * @return bool
     */
    public function wasSubmitted() {
        return array_key_exists($this->getSlug(), $_POST) && $_POST[$this->getSlug()] !== "";
    }

    /**
     * @return string
     */
    public function getLabel() {
        return $this->_label;
    }

    /**
     * @param string $label
     */
    public function setLabel($label) {
        $this->_label = $label;
    }

    /**
     * @return array
     */
    public function getChoices() {
        return $this->_choices;
    }

    /**
     * @param array $choices
     */
    public function setChoices(array $choices) {
        $this->_choices = $choices;
    }

    /**
     * @return int
     */
    public function getSize() {
        return $this->_fieldSize;
    }

    /**
     * @param int $size
     */
    public function setSize($size) {
        $this->_fieldSize = $size;
    }

    /**
     * @return string
     */
    public function getType() {
        return $this->_type;
    }

    /**
     * @param string $type
     */
    public function setType($type) {
        $this->_type = $type;
    }

    /**
     * @param string $suffix
     */
    public function addSuffix($suffix) {
        $this->_suffixes[] = $suffix;
    }

    /**
     * @return string[]
     */
    public function getSuffixes() {
        return $this->_suffixes;
    }

    /**
     * @param string $prefix
     */
    public function addPrefix($prefix) {
        $this->_prefixes[] = $prefix;
    }

    /**
     * @return string[]
     */
    public function getPrefixes() {
        return $this->_prefixes;
    }

    /**
     * @return string
     */
    public function getLabelSlug() {
        return StringUtils::slugify($this->_label);
    }

    /**
     * @return string
     */
    public function getSlug() {
        return implode("-", array_merge($this->getPrefixes(), [$this->getLabelSlug()], $this->getSuffixes()));
    }

    /**
     * @param string $value
     */
    public function setInitial($value) {
        $this->_initial = $value;
    }

    /**
     * @return string
     */
    public function getInitial() {
        if ($this->getType() !== "literal" && $this->wasSubmitted()) {
            $result = $this->getSubmitted();
        } else {
            $result = $this->_initial;
        }
        return $result;
    }

    /**
     * @param string $error
     */
    public function addError($error) {
        $this->_fieldErrors[] = $error;
    }

    /**
     * @return string[]
     */
    public function getErrors() {
        return $this->_fieldErrors;
    }

    /**
     * @return null
     */
    public function removeErrors() {
        $this->_fieldErrors = [];
    }

    /**
     * @return null
     */
    public function validate() {

        $data = $this->wasSubmitted() ? $this->getSubmitted() : null;

        if ($this->isRequired() && is_null($data)) {
            $this->addError("This field is required.");
        }

        if (sizeof($this->getChoices()) > 0 && array_search($data, $this->getChoices()) === false) {
            $this->addError("The value of this field must be one of: " . implode(", ", $this->getChoices()) . ".");
        }

        if (!$this->getErrors()) {
            $this->setValidatedData($data);
        }
    }

    /**
     * @return bool
     */
    public function isRequired() {
        return $this->_required && $this->getType() != "hidden";
    }

    /**
     * @param bool $required
     */
    public function setRequired($required) {
        $this->_required = $required;
    }

    /**
     * @return bool
     */
    public function isValid() {
        return empty($this->_fieldErrors);
    }

    /**
     * @param string $data
     */
    public function setValidatedData($data) {
        $this->_validatedData = $data;
    }

    /**
     * @return string
     */
    public function getValidatedData() {
        return $this->_validatedData;
    }
}