<?php

namespace Athens\Core\ORMWrapper;

/**
 * Class AbstractORMWrapper
 *
 * @package Athens\Core\ORMWrapper
 */
abstract class AbstractORMWrapper implements ORMWrapperInterface
{

    /**
     * @return string
     */
    public function getPascalCasedObjectName()
    {
        return str_replace(' ', '', ucwords($this->getTitleCasedObjectName()));
    }

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
        $columnNames = $this->getUnqualifiedTitleCasedColumnNames();

        foreach ($columnNames as $key => $columnName) {
            $columnNames[$key] = str_replace(' ', '', ucwords($columnName));
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
}
