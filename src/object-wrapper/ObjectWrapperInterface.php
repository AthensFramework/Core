<?php

namespace Athens\Core\ObjectWrapper;

use Athens\Core\Field\FieldInterface;


interface ObjectWrapperInterface
{
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
    public function getPk();
    
    /**
     * @return string
     */
    public function getPascalCasedObjectName();

    /**
     * @return string
     */
    public function getTitleCasedObjectName();

    /**
     * @return string[]
     */
    public function getQualifiedPascalCasedColumnNames();

    /**
     * @return string[]
     */
    public function getUnqualifiedPascalCasedColumnNames();

    /**
     * @return string[]
     */
    public function getQualifiedTitleCasedColumnNames();

    /**
     * @return string[]
     */
    public function getUnqualifiedTitleCasedColumnNames();

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

}