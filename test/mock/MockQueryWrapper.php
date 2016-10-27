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
        return $this->query->find();
    }

    public function createObject()
    {
        return MockObjectWrapper::fromObject(new MockObject($this->query->titleCasedObjectName, [], null, []));
    }

    public function orderBy($fieldName, $criteria)
    {
        $this->query->orderBy($fieldName, $criteria);

        return $this;
    }
    
    public function filterBy($columnName, $value, $condition = QueryWrapperInterface::CONDITION_EQUAL)
    {
        $this->query->filterBy($columnName, $condition, $value);

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

    public function canFilterBy($columnName, $value, $condition = QueryWrapperInterface::CONDITION_EQUAL)
    {
        return in_array($columnName, $this->query->getQualifiedPascalCasedColumnNames());
    }

    public function canOrderBy($columnName, $condition)
    {
        return in_array($columnName, $this->query->getQualifiedPascalCasedColumnNames());
    }
}
