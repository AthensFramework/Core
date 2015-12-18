<?php

namespace UWDOEM\Framework\Field;

use UWDOEM\Framework\Writer\WritableInterface;

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
     * @return void
     */
    public function setLabel($label);

    /** @return string[] */
    public function getChoices();

    /** @return string[] */
    public function getChoiceSlugs();

    /**
     * @param array $choices
     * @return void
     */
    public function setChoices(array $choices);

    /** @return int */
    public function getSize();

    /**
     * @param integer $size
     * @return void
     */
    public function setSize($size);

    /** @return string */
    public function getType();

    /**
     * @param string $type
     * @return void
     */
    public function setType($type);

    /**
     * @param string $suffix
     * @return void
     */
    public function addSuffix($suffix);

    /** @return string[] */
    public function getSuffixes();

    /**
     * @param string $prefix
     * @return void
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
     * @return void
     */
    public function setInitial($value);

    /** @return string|string[] */
    public function getInitial();

    /**
     * @param string $error
     * @return void
     */
    public function addError($error);

    /** @return string[] */
    public function getErrors();

    /** @return void */
    public function removeErrors();

    /** @return void */
    public function validate();

    /** @return bool */
    public function isRequired();

    /**
     * @param boolean $required
     * @return void
     */
    public function setRequired($required);

    /** @return bool */
    public function isValid();

    /**
     * @param string $data
     * @return void
     */
    public function setValidatedData($data);

    /** @return string */
    public function getValidatedData();
}
