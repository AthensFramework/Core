<?php

namespace UWDOEM\Framework\FieldBearer;

use UWDOEM\Framework\Field\Field;


interface FieldBearerInterface {

    /**
     * @return FieldBearerInterface[]
     */
    function getFieldBearers();

    /**
     * @param String $name
     * @return FieldBearerInterface
     */
    function getFieldBearerByName($name);

    /**
     * Given a field's string name, return the field.
     *
     * @param string $name
     * @return Field
     * @throws \Exception
     */
    function getFieldByName($name);

    /**
     * @param Field $field
     * @return String
     */
    function getNameByField($field);

    /**
     * Return the array of child fields.
     * @return Field[]
     */
    function getFields();

    /**
     * @return Field[]
     */
    function getVisibleFields();

    /**
     * @return Field[]
     */
    function getHiddenFields();

    /**
     * @return String[]
     */
    function getFieldNames();

    /**
     * @return String[]
     */
    function getVisibleFieldNames();

    /**
     * @return String[]
     */
    function getHiddenFieldNames();

    /**
     * Return the labels of the child fields.
     *
     * @return String[]
     */
    function getLabels();

    /**
     * @return String[]
     */
    function getVisibleLabels();

    /**
     * @return String[]
     */
    function getHiddenLabels();

    /**
     * @param mixed ...
     * @return mixed
     */
    function save();

}