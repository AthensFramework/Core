<?php

namespace Athens\Core\Test\Mock;

class MockQuery
{

    /** @var MockObject[] */
    public $instances;
    
    /** @var string */
    public $titleCasedObjectName;

    /**
     * MockQuery constructor.
     * 
     * @param string $titleCasedObjectName
     * @param MockObject[] $instances
     */
    public function __construct($titleCasedObjectName, array $instances)
    {
        $this->instances = $instances;
        $this->titleCasedObjectName = $titleCasedObjectName;
    }
    
    public function findOneByPk($pk)
    {
    }

    public function find()
    {
    }
    
    public function orderBy($fieldName, $condition)
    {
    }

    public function filterBy($fieldName, $condition, $criterion)
    {
    }
    
    public function offset($offset)
    {
    }
    
    public function limit($limit)
    {
    }
}