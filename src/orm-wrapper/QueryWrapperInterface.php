<?php

namespace Athens\Core\ORMWrapper;

interface QueryWrapperInterface extends ORMWrapperInterface
{
    const CONDITION_NOT_EQUAL = 'not equal';
    const CONDITION_EQUAL = 'equal';
    const CONDITION_GREATER_THAN = 'greater';
    const CONDITION_GREATER_THAN_OR_EQUAL = 'greater or equal';
    const CONDITION_LESS_THAN = 'less';
    const CONDITION_LESS_THAN_OR_EQUAL = 'less or equal';
    const CONDITION_CONTAINS = 'contains';

    const ORDER_ASCENDING = 'ascending';
    const ORDER_DESCENDING = 'descending';

    /**
     * @param mixed $query
     * @return QueryWrapperInterface
     */
    public static function fromQuery($query);

    /**
     * @param mixed $primaryKeyValue
     * @return ObjectWrapperInterface|null
     */
    public function findOneByPrimaryKey($primaryKeyValue);

    /**
     * @return CollectionWrapperInterface
     */
    public function find();

    /**
     * @param string $columnName
     * @param mixed  $condition
     * @return QueryWrapperInterface
     */
    public function orderBy($columnName, $condition);

    /**
     * @param string $columnName
     * @param mixed  $value
     * @param string $condition
     * @return QueryWrapperInterface
     */
    public function filterBy($columnName, $value, $condition = QueryWrapperInterface::CONDITION_EQUAL);

    /**
     * @param integer $offset
     * @return QueryWrapperInterface
     */
    public function offset($offset);

    /**
     * @param integer $limit
     * @return QueryWrapperInterface
     */
    public function limit($limit);

    /**
     * @return ObjectWrapperInterface
     */
    public function createObject();

    /**
     * @return integer
     */
    public function count();

    /**
     * @return boolean
     */
    public function exists();
}
