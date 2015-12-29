<?php

namespace UWDOEM\Framework\FieldBearer;

use UWDOEM\Framework\Field\FieldInterface;
use UWDOEM\Framework\Initializer\InitializableInterface;

interface FieldBearerInterface extends InitializableInterface
{

    /**
     * @return FieldBearerInterface[]
     */
    public function getFieldBearers();

    /**
     * @param string $name
     * @return FieldBearerInterface
     */
    public function getFieldBearerByName($name);

    /**
     * Given a field's string name, return the field.
     *
     * @param string $name
     * @return FieldInterface
     */
    public function getFieldByName($name);

    /**
     * @param FieldInterface $field
     * @return string
     */
    public function getNameByField(FieldInterface $field);

    /**
     * Return the array of child fields.
     * @return FieldInterface[]
     */
    public function getFields();

    /**
     * @return FieldInterface[]
     */
    public function getVisibleFields();

    /**
     * @return FieldInterface[]
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
     * @return mixed
     */
    public function save();
}
