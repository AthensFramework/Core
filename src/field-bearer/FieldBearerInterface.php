<?php

namespace UWDOEM\Framework\FieldBearer;

use UWDOEM\Framework\Field\Field;
use UWDOEM\Framework\Initializer\InitializableInterface;

interface FieldBearerInterface extends InitializableInterface
{

    /**
     * @return FieldBearerInterface[]
     */
    public function getFieldBearers();

    /**
     * @param String $name
     * @return FieldBearerInterface
     */
    public function getFieldBearerByName($name);

    /**
     * Given a field's string name, return the field.
     *
     * @param string $name
     * @return Field
     * @throws \Exception
     */
    public function getFieldByName($name);

    /**
     * @param Field $field
     * @return String
     */
    public function getNameByField($field);

    /**
     * Return the array of child fields.
     * @return Field[]
     */
    public function getFields();

    /**
     * @return Field[]
     */
    public function getVisibleFields();

    /**
     * @return Field[]
     */
    public function getHiddenFields();

    /**
     * @return String[]
     */
    public function getFieldNames();

    /**
     * @return String[]
     */
    public function getVisibleFieldNames();

    /**
     * @return String[]
     */
    public function getHiddenFieldNames();

    /**
     * Return the labels of the child fields.
     *
     * @return String[]
     */
    public function getLabels();

    /**
     * @return String[]
     */
    public function getVisibleLabels();

    /**
     * @return String[]
     */
    public function getHiddenLabels();

    /**
     * @param mixed ...
     * @return mixed
     */
    public function save();
}
