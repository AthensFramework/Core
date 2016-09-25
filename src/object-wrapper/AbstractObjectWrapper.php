<?php

namespace Athens\Core\ObjectWrapper;


abstract class AbstractObjectWrapper implements ObjectWrapperInterface
{
    /**
     * @return string
     */
    public function getPascalCasedObjectName()
    {
        return str_replace(' ', '', ucwords($this->getTitleCasedObjectName()));
    }

    /**
     * @return string
     */
    abstract public function getTitleCasedObjectName();

    /**
     * @return string[]
     */
    public function getQualifiedPascalCasedColumnNames()
    {
        $columnNames = $this->getUnqualifiedPascalCasedColumnNames();
        $objectName = $this->getPascalCasedObjectName();
        
        foreach ($columnNames as $key => $columnName) {
            $columnNames[$key] = "$objectName.$columnName";
        }
        
        return $columnNames;
    }

    /**
     * @return string[]
     */
    public function getUnqualifiedPascalCasedColumnNames()
    {
        $columnNames = $this->getQualifiedTitleCasedColumnNames();

        foreach ($columnNames as $key => $columnName) {
            $columnNames[$key] = str_replace(' ', '', ucwords($columnName);
        }
        
        return $columnNames;
    }

    /**
     * @return string[]
     */
    public function getQualifiedTitleCasedColumnNames()
    {
        $columnNames = $this->getUnqualifiedTitleCasedColumnNames();
        $objectName = $this->getTitleCasedObjectName();

        foreach ($columnNames as $key => $columnName) {
            $columnNames[$key] = "$objectName $columnName";
        }

        return $columnNames;
    }

    /**
     * @return string[]
     */
    abstract public function getUnqualifiedTitleCasedColumnNames();

    /**
     * @return ObjectWrapperInterface
     */
    abstract public function save();

    /**
     * @return void
     */
    abstract public function delete();

}