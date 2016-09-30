<?php

namespace Athens\Core\Test\Mock;

use Athens\Core\ORMWrapper\AbstractQueryWrapper;
use Athens\Core\ORMWrapper\QueryWrapperInterface;

class MockQueryWrapper extends AbstractQueryWrapper implements QueryWrapperInterface
{
    /** @var MockQuery */
    protected $query;
    
    public function __construct($query)
    {
        $this->query = $query;
    }

    public function findOneByPrimaryKey($primaryKeyValue)
    {
        return $this->query->findOneByPk($primaryKeyValue);
    }
    
    public function find()
    {
        $objects = $this->query->find();

        foreach ($objects as $key => $object) {
            $objects[$key] = new MockObjectWrapper($object);
        }

        return $objects;
    }

    public function createObject()
    {
        return new MockObjectWrapper(new MockObject($this->query->titleCasedObjectName, [], null, []));
    }

    public function orderBy($fieldName, $criteria)
    {
        $this->query->orderBy($fieldName, $criteria);

        return $this;
    }
    
    public function filterBy($fieldName, $criteria, $criterion)
    {
        $this->query->filterBy($fieldName, $criteria, $criterion);

        return $this;
    }
    
    public function limit($limit)
    {
        $this->query->limit($limit);

        return $this;
    }
    
    public function offset($offset)
    {
        $this->query->offset($offset);

        return $this;
    }
    
    public function count()
    {
        return $this->query->count();
    }
    
    public function exists()
    {
        return $this->query->exists();
    }
    
    public function getUnqualifiedTitleCasedColumnNames()
    {
        return $this->query->getUnqualifiedTitleCasedColumnNames();
    }

    public function getTitleCasedObjectName()
    {
        return $this->query->getTitleCasedObjectName();
    }
}
