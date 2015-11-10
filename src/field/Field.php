<?php

namespace UWDOEM\Framework\Field;

use UWDOEM\Framework\Etc\StringUtils;
use UWDOEM\Framework\Visitor\VisitableTrait;

/**
 * Class Field provides a small, typed data container for display and
 * user submission.
 *
 * @package UWDOEM\Framework\Field
 */
class Field implements FieldInterface {

    const FIELD_TYPE_TEXT = "text";
    const FIELD_TYPE_TEXTAREA = "textarea";
    const FIELD_TYPE_CHOICE = "choice";
    const FIELD_TYPE_MULTIPLE_CHOICE = "multiple-choice";
    const FIELD_TYPE_LITERAL = "literal";
    const FIELD_TYPE_SECTION_LABEL = "section-label";
    const FIELD_TYPE_PRIMARY_KEY = "primary-key";
    const FIELD_TYPE_FOREIGN_KEY = "foreign-key";
    const FIELD_TYPE_AUTO_TIMESTAMP = "auto-timestamp";

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
    protected $_fieldErrors = [];

    /** @var string[] */
    protected $_prefixes = [];

    /** @var string[] */
    protected $_suffixes = [];

    /** @var string */
    protected $_validatedData;

    /** @var bool */
    protected $_isValid;

    /** @var string[] */
    protected $_choices;

    use VisitableTrait;


    function getHash() {
        return md5($this->getSlug());
    }

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
        $fieldType = $this->getType();

        if ($fieldType == "checkbox") {
            $data = (string)array_key_exists($this->getSlug(), $_POST);
        } else {
            $data = array_key_exists($this->getSlug(), $_POST) ? $_POST[$this->getSlug()]: "";
        }

        if (in_array($fieldType, [static::FIELD_TYPE_CHOICE, static::FIELD_TYPE_MULTIPLE_CHOICE])){
            $data = $this->parseChoiceSlugs($data);
        }

        return $data;
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
     * @return string[]
     */
    public function getChoices() {
        return $this->_choices;
    }

    /**
     * @return string[]
     */
    public function getChoiceSlugs() {
        return array_map(
            function($choice) {
                return StringUtils::slugify($choice);
            },
            $this->_choices
        );
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
        return $this->_initial;
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

        // Invalid selection on choice/multiple choice field
        if ($data === []) {
            $this->addError("Unrecognized choice.");
        }

        if ($this->isRequired() && is_null($data)) {
            $this->addError("This field is required.");
        }

        if (!$this->getErrors()) {
            $this->setValidatedData($data);
        }
    }

    /**
     * @return bool
     */
    protected function hasChoices() {
        return (bool)$this->getChoices();
    }

    protected function parseChoiceSlugs($slugs) {
        $choices = array_combine($this->getChoiceSlugs(), $this->getChoices());

        if ($this->getType() === static::FIELD_TYPE_CHOICE) {
            $slugs = [$slugs];
        }

        $result = [];
        foreach($slugs as $choiceSlug) {
            if (array_key_exists($choiceSlug, $choices)) {
                $result[] = $choices[$choiceSlug];
            }
        }

        if ($this->getType() === static::FIELD_TYPE_CHOICE && !empty($result)) {
            $result = $result[0];
        }

        return $result;

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