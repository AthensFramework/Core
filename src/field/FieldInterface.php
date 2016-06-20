<?php

namespace Athens\Core\Field;

use Athens\Core\Writer\WritableInterface;
use Athens\Core\Choice\ChoiceInterface;

interface FieldInterface extends WritableInterface
{

    /** @return string */
    public function getSubmitted();

    /** @return boolean */
    public function wasSubmitted();

    /** @return string */
    public function getLabel();

    /**
     * @param string $label
     * @return FieldInterface
     */
    public function setLabel($label);

    /** @return ChoiceInterface[] */
    public function getChoices();

    /** @return string[] */
    public function getChoiceSlugs();

    /**
     * @param ChoiceInterface[] $choices
     * @return FieldInterface
     */
    public function setChoices(array $choices);

    /** @return int */
    public function getSize();

    /**
     * @param integer $size
     * @return FieldInterface
     */
    public function setSize($size);

    /** @return string */
    public function getType();

    /**
     * @param string $type
     * @return FieldInterface
     */
    public function setType($type);

    /**
     * @param string $suffix
     * @return FieldInterface
     */
    public function addSuffix($suffix);

    /** @return string[] */
    public function getSuffixes();

    /**
     * @param string $prefix
     * @return FieldInterface
     */
    public function addPrefix($prefix);

    /** @return string[] */
    public function getPrefixes();

    /** @return string */
    public function getLabelSlug();

    /** @return string */
    public function getSlug();

    /**
     * @param string|string[] $value
     * @return FieldInterface
     */
    public function setInitial($value);

    /** @return string|string[] */
    public function getInitial();

    /**
     * @param string $error
     * @return FieldInterface
     */
    public function addError($error);

    /** @return string[] */
    public function getErrors();

    /** @return FieldInterface */
    public function removeErrors();

    /** @return void */
    public function validate();

    /** @return bool */
    public function isRequired();

    /**
     * @param boolean $required
     * @return FieldInterface
     */
    public function setRequired($required);

    /** @return bool */
    public function isValid();

    /**
     * @param string $data
     * @return FieldInterface
     */
    public function setValidatedData($data);

    /** @return boolean */
    public function hasValidatedData();

    /** @return string */
    public function getValidatedData();

    /**
     * @return string
     */
    public function getHelptext();

    /**
     * @param string $helptext
     * @return FieldInterface
     */
    public function setHelptext($helptext);

    /**
     * @return string
     */
    public function getPlaceholder();

    /**
     * @param string $placeholder
     * @return FieldInterface
     */
    public function setPlaceholder($placeholder);
}
