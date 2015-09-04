<?php

namespace UWDOEM\Framework\Field;


use UWDOEM\Framework\Writer\WritableInterface;


interface FieldInterface extends WritableInterface {

    /** @return string */
    function getSubmitted();

    /** @return boolean */
    function wasSubmitted();

    /** @return string */
    function getLabel();

    /** @param string $label */
    function setLabel($label);

    /** @return string */
    function getChoices();

    /** @param array $choices */
    function setChoices(array $choices);

    /** @return int */
    function getSize();

    /** @param int $size */
    function setSize($size);

    /** @return string */
    function getType();

    /** @param string $type */
    function setType($type);

    /** @param string $suffix */
    function addSuffix($suffix);

    /** @return string[] */
    function getSuffixes();

    /** @param string $prefix */
    function addPrefix($prefix);

    /** @return string[] */
    function getPrefixes();

    /** @return string */
    function getLabelSlug();

    /** @return string */
    function getSlug();

    /** @param string|string[] $value */
    function setInitial($value);

    /** @return string|string[] */
    function getInitial();

    /** @param string $error */
    function addError($error);

    /** @return string[] */
    function getErrors();

    /** @return null */
    function removeErrors();

    /** @return null */
    function validate();

    /** @return bool */
    function isRequired();

    /** @param bool $required */
    function setRequired($required);

    /** @return bool */
    function isValid();

    /** @param string $data */
    function setValidatedData($data);

    /** @return string */
    function getValidatedData();

}