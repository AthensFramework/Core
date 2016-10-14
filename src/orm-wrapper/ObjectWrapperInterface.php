<?php

namespace Athens\Core\ORMWrapper;

use Athens\Core\Field\FieldInterface;

interface ObjectWrapperInterface extends ORMWrapperInterface
{

    /**
     * @param mixed $object
     * @return ObjectWrapperInterface
     */
    public static function fromObject($object);

    /**
     * @return FieldInterface[]
     */
    public function getFields();

    /**
     * @return mixed[]
     */
    public function getValues();

    /**
     * @return mixed
     */
    public function getPrimaryKey();
    
    /**
     * @param FieldInterface[] $fields
     * @return ObjectWrapperInterface
     */
    public function fillFromFields(array $fields);

    /**
     * @return ObjectWrapperInterface
     */
    public function save();

    /**
     * @return void
     */
    public function delete();

    /**
     * @return string
     */
    public function __toString();
}
