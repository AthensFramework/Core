<?php

namespace Athens\Core\ORMWrapper;

interface ORMWrapperInterface
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
}
