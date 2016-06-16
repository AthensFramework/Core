<?php

namespace Athens\Core\Test\Mock;

use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\Connection\ConnectionInterface;

use AthensTest\TestClassQuery;

class MockQuery extends TestClassQuery
{
    public $orderByStatements = [];
    public $aliasedStatements = [];

    public $setOffset;
    public $setLimit;

    public $count;
    
    public $find;

    public function orderBy($columnName, $order = Criteria::ASC)
    {
        $this->orderByStatements[] = [$columnName, $order];
        return $this;
    }

    public function filterBy($column, $value, $comparison = Criteria::EQUAL)
    {
        $this->aliasedStatements[] = [$column, $value, $comparison];
        return $this;
    }

    public function addUsingAlias($p1, $value = null, $operator = null)
    {
        $this->aliasedStatements[] = [$p1, $value, $operator];
        return $this;
    }

    public function limit($limit)
    {
        $this->setLimit = $limit;
        return $this;
    }

    public function offset($offset)
    {
        $this->setOffset = $offset;
        return $this;
    }

    public function count(ConnectionInterface $con = null)
    {
        if (isset($this->count)) {
            return $this->count;
        } else {
            return parent::count($con);
        }
    }
    
    public function find(ConnectionInterface $con = null)
    {
        if (isset($this->find)) {
            return $this->find;
        } else {
            return parent::find($con);
        }
    }
}
