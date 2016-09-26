<?php

namespace Athens\Core\Test\Mock;

use Athens\Core\QueryWrapper\AbstractQueryWrapper;
use Athens\Core\QueryWrapper\QueryWrapperInterface;

class MockQueryWrapper extends AbstractQueryWrapper implements QueryWrapperInterface
{
    /** @var MockQuery */
    protected $query;
    
    public function __construct($query)
    {
        $this->query = $query;
    }

    public function findOneByPk($pk)
    {
        return $this->query->findOneByPk($pk);
    }
    
    public function find()
    {
        $objects = $this->query->find();

        foreach ($objects as $key => $object) {
            $objects[$key] = new MockObjectWrapper($object);
        }

        return $objects;
    }

    public function getTitleCasedObjectName()
    {
        return $this->query->titleCasedObjectName;
    }

    public function createObject()
    {
        return new MockObjectWrapper(new MockObject($this->query->titleCasedObjectName, [], null, []));
    }

    public function orderBy($fieldName, $criteria)
    {
        return $this->query->orderBy($fieldName, $criteria);
    }
    
    public function filterBy($fieldName, $criteria, $criterion)
    {
        return $this->query->filterBy($fieldName, $criteria, $criterion);
    }
    
    public function limit($limit)
    {
        return $this->query->limit($limit);
    }
    
    public function offset($offset)
    {
        return $this->query->offset($offset);
    }
    

}
