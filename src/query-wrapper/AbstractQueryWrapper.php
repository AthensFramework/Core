<?php

namespace Athens\Core\QueryWrapper;


abstract class AbstractQueryWrapper implements QueryWrapperInterface
{
    /**
     * @return string
     */
    public function getPascalCasedObjectName()
    {
        return str_replace(' ', '', ucwords($this->getTitleCasedObjectName()));
    }

}