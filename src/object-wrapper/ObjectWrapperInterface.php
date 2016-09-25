<?php

namespace Athens\Core\ObjectWrapper;


interface ObjectWrapperInterface
{
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
     * @return ObjectWrapperInterface
     */
    public function save();

    /**
     * @return void
     */
    public function delete();

}