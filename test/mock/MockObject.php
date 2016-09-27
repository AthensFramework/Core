<?php

namespace Athens\Core\Test\Mock;

class MockObject
{
    /** @var string */
    public $titleCasedName;
    
    /** @var string[] */
    public $titleCasedColumnNames;
    
    /** @var mixed[] */
    public $values;
    
    /** @var integer */
    public $pk;

    /**
     * MockObject constructor.
     * @param string $titleCasedName
     * @param string[] $titleCasedColumnNames
     * @param integer $pk
     * @param mixed[] $values
     */
    public function __construct($titleCasedName, $titleCasedColumnNames, $pk, $values)
    {
        $this->titleCasedName = $titleCasedName;
        $this->titleCasedColumnNames = $titleCasedColumnNames;
        $this->values = $values;
        $this->pk = $pk;
    }

    public function save()
    {
    }

    public function delete()
    {
    }

    public function getTitleCasedColumnNames()
    {
        return $this->titleCasedColumnNames;
    }
    
    public function getTitleCasedName()
    {
        return $this->titleCasedName;
    }

    public function getQualifiedPascalCasedColumnNames()
    {
    }

    public function getValues()
    {
        return $this->values;
    }
    
    public function fillFromFields(array $fields)
    {
        return $this;
    }
}
