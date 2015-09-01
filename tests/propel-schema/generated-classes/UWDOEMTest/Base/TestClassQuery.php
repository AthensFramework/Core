<?php

namespace UWDOEMTest\Base;

use \Exception;
use \PDO;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use UWDOEMTest\TestClass as ChildTestClass;
use UWDOEMTest\TestClassQuery as ChildTestClassQuery;
use UWDOEMTest\Map\TestClassTableMap;

/**
 * Base class that represents a query for the 'test_class' table.
 *
 * 
 *
 * @method     ChildTestClassQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildTestClassQuery orderByFieldSmallVarchar($order = Criteria::ASC) Order by the field_small_varchar column
 * @method     ChildTestClassQuery orderByFieldLargeVarchar($order = Criteria::ASC) Order by the field_large_varchar column
 * @method     ChildTestClassQuery orderByFieldInteger($order = Criteria::ASC) Order by the field_integer column
 * @method     ChildTestClassQuery orderByFieldFloat($order = Criteria::ASC) Order by the field_float column
 * @method     ChildTestClassQuery orderByFieldTimestamp($order = Criteria::ASC) Order by the field_timestamp column
 * @method     ChildTestClassQuery orderByFieldBoolean($order = Criteria::ASC) Order by the field_boolean column
 * @method     ChildTestClassQuery orderByRequiredField($order = Criteria::ASC) Order by the required_field column
 * @method     ChildTestClassQuery orderByUnrequiredField($order = Criteria::ASC) Order by the unrequired_field column
 * @method     ChildTestClassQuery orderByEncryptedField($order = Criteria::ASC) Order by the encrypted_field column
 *
 * @method     ChildTestClassQuery groupById() Group by the id column
 * @method     ChildTestClassQuery groupByFieldSmallVarchar() Group by the field_small_varchar column
 * @method     ChildTestClassQuery groupByFieldLargeVarchar() Group by the field_large_varchar column
 * @method     ChildTestClassQuery groupByFieldInteger() Group by the field_integer column
 * @method     ChildTestClassQuery groupByFieldFloat() Group by the field_float column
 * @method     ChildTestClassQuery groupByFieldTimestamp() Group by the field_timestamp column
 * @method     ChildTestClassQuery groupByFieldBoolean() Group by the field_boolean column
 * @method     ChildTestClassQuery groupByRequiredField() Group by the required_field column
 * @method     ChildTestClassQuery groupByUnrequiredField() Group by the unrequired_field column
 * @method     ChildTestClassQuery groupByEncryptedField() Group by the encrypted_field column
 *
 * @method     ChildTestClassQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildTestClassQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildTestClassQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildTestClassQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildTestClassQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildTestClassQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildTestClass findOne(ConnectionInterface $con = null) Return the first ChildTestClass matching the query
 * @method     ChildTestClass findOneOrCreate(ConnectionInterface $con = null) Return the first ChildTestClass matching the query, or a new ChildTestClass object populated from the query conditions when no match is found
 *
 * @method     ChildTestClass findOneById(int $id) Return the first ChildTestClass filtered by the id column
 * @method     ChildTestClass findOneByFieldSmallVarchar(string $field_small_varchar) Return the first ChildTestClass filtered by the field_small_varchar column
 * @method     ChildTestClass findOneByFieldLargeVarchar(string $field_large_varchar) Return the first ChildTestClass filtered by the field_large_varchar column
 * @method     ChildTestClass findOneByFieldInteger(int $field_integer) Return the first ChildTestClass filtered by the field_integer column
 * @method     ChildTestClass findOneByFieldFloat(double $field_float) Return the first ChildTestClass filtered by the field_float column
 * @method     ChildTestClass findOneByFieldTimestamp(string $field_timestamp) Return the first ChildTestClass filtered by the field_timestamp column
 * @method     ChildTestClass findOneByFieldBoolean(boolean $field_boolean) Return the first ChildTestClass filtered by the field_boolean column
 * @method     ChildTestClass findOneByRequiredField(string $required_field) Return the first ChildTestClass filtered by the required_field column
 * @method     ChildTestClass findOneByUnrequiredField(string $unrequired_field) Return the first ChildTestClass filtered by the unrequired_field column
 * @method     ChildTestClass findOneByEncryptedField(string $encrypted_field) Return the first ChildTestClass filtered by the encrypted_field column *

 * @method     ChildTestClass requirePk($key, ConnectionInterface $con = null) Return the ChildTestClass by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTestClass requireOne(ConnectionInterface $con = null) Return the first ChildTestClass matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTestClass requireOneById(int $id) Return the first ChildTestClass filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTestClass requireOneByFieldSmallVarchar(string $field_small_varchar) Return the first ChildTestClass filtered by the field_small_varchar column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTestClass requireOneByFieldLargeVarchar(string $field_large_varchar) Return the first ChildTestClass filtered by the field_large_varchar column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTestClass requireOneByFieldInteger(int $field_integer) Return the first ChildTestClass filtered by the field_integer column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTestClass requireOneByFieldFloat(double $field_float) Return the first ChildTestClass filtered by the field_float column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTestClass requireOneByFieldTimestamp(string $field_timestamp) Return the first ChildTestClass filtered by the field_timestamp column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTestClass requireOneByFieldBoolean(boolean $field_boolean) Return the first ChildTestClass filtered by the field_boolean column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTestClass requireOneByRequiredField(string $required_field) Return the first ChildTestClass filtered by the required_field column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTestClass requireOneByUnrequiredField(string $unrequired_field) Return the first ChildTestClass filtered by the unrequired_field column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTestClass requireOneByEncryptedField(string $encrypted_field) Return the first ChildTestClass filtered by the encrypted_field column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTestClass[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildTestClass objects based on current ModelCriteria
 * @method     ChildTestClass[]|ObjectCollection findById(int $id) Return ChildTestClass objects filtered by the id column
 * @method     ChildTestClass[]|ObjectCollection findByFieldSmallVarchar(string $field_small_varchar) Return ChildTestClass objects filtered by the field_small_varchar column
 * @method     ChildTestClass[]|ObjectCollection findByFieldLargeVarchar(string $field_large_varchar) Return ChildTestClass objects filtered by the field_large_varchar column
 * @method     ChildTestClass[]|ObjectCollection findByFieldInteger(int $field_integer) Return ChildTestClass objects filtered by the field_integer column
 * @method     ChildTestClass[]|ObjectCollection findByFieldFloat(double $field_float) Return ChildTestClass objects filtered by the field_float column
 * @method     ChildTestClass[]|ObjectCollection findByFieldTimestamp(string $field_timestamp) Return ChildTestClass objects filtered by the field_timestamp column
 * @method     ChildTestClass[]|ObjectCollection findByFieldBoolean(boolean $field_boolean) Return ChildTestClass objects filtered by the field_boolean column
 * @method     ChildTestClass[]|ObjectCollection findByRequiredField(string $required_field) Return ChildTestClass objects filtered by the required_field column
 * @method     ChildTestClass[]|ObjectCollection findByUnrequiredField(string $unrequired_field) Return ChildTestClass objects filtered by the unrequired_field column
 * @method     ChildTestClass[]|ObjectCollection findByEncryptedField(string $encrypted_field) Return ChildTestClass objects filtered by the encrypted_field column
 * @method     ChildTestClass[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class TestClassQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \UWDOEMTest\Base\TestClassQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'uwdoem_test', $modelName = '\\UWDOEMTest\\TestClass', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildTestClassQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildTestClassQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildTestClassQuery) {
            return $criteria;
        }
        $query = new ChildTestClassQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildTestClass|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = TestClassTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TestClassTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildTestClass A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, field_small_varchar, field_large_varchar, field_integer, field_float, field_timestamp, field_boolean, required_field, unrequired_field, encrypted_field FROM test_class WHERE id = :p0';
        try {
            $stmt = $con->prepare($sql);            
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildTestClass $obj */
            $obj = new ChildTestClass();
            $obj->hydrate($row);
            TestClassTableMap::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildTestClass|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildTestClassQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(TestClassTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildTestClassQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(TestClassTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTestClassQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(TestClassTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(TestClassTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TestClassTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the field_small_varchar column
     *
     * Example usage:
     * <code>
     * $query->filterByFieldSmallVarchar('fooValue');   // WHERE field_small_varchar = 'fooValue'
     * $query->filterByFieldSmallVarchar('%fooValue%'); // WHERE field_small_varchar LIKE '%fooValue%'
     * </code>
     *
     * @param     string $fieldSmallVarchar The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTestClassQuery The current query, for fluid interface
     */
    public function filterByFieldSmallVarchar($fieldSmallVarchar = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($fieldSmallVarchar)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $fieldSmallVarchar)) {
                $fieldSmallVarchar = str_replace('*', '%', $fieldSmallVarchar);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TestClassTableMap::COL_FIELD_SMALL_VARCHAR, $fieldSmallVarchar, $comparison);
    }

    /**
     * Filter the query on the field_large_varchar column
     *
     * Example usage:
     * <code>
     * $query->filterByFieldLargeVarchar('fooValue');   // WHERE field_large_varchar = 'fooValue'
     * $query->filterByFieldLargeVarchar('%fooValue%'); // WHERE field_large_varchar LIKE '%fooValue%'
     * </code>
     *
     * @param     string $fieldLargeVarchar The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTestClassQuery The current query, for fluid interface
     */
    public function filterByFieldLargeVarchar($fieldLargeVarchar = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($fieldLargeVarchar)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $fieldLargeVarchar)) {
                $fieldLargeVarchar = str_replace('*', '%', $fieldLargeVarchar);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TestClassTableMap::COL_FIELD_LARGE_VARCHAR, $fieldLargeVarchar, $comparison);
    }

    /**
     * Filter the query on the field_integer column
     *
     * Example usage:
     * <code>
     * $query->filterByFieldInteger(1234); // WHERE field_integer = 1234
     * $query->filterByFieldInteger(array(12, 34)); // WHERE field_integer IN (12, 34)
     * $query->filterByFieldInteger(array('min' => 12)); // WHERE field_integer > 12
     * </code>
     *
     * @param     mixed $fieldInteger The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTestClassQuery The current query, for fluid interface
     */
    public function filterByFieldInteger($fieldInteger = null, $comparison = null)
    {
        if (is_array($fieldInteger)) {
            $useMinMax = false;
            if (isset($fieldInteger['min'])) {
                $this->addUsingAlias(TestClassTableMap::COL_FIELD_INTEGER, $fieldInteger['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fieldInteger['max'])) {
                $this->addUsingAlias(TestClassTableMap::COL_FIELD_INTEGER, $fieldInteger['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TestClassTableMap::COL_FIELD_INTEGER, $fieldInteger, $comparison);
    }

    /**
     * Filter the query on the field_float column
     *
     * Example usage:
     * <code>
     * $query->filterByFieldFloat(1234); // WHERE field_float = 1234
     * $query->filterByFieldFloat(array(12, 34)); // WHERE field_float IN (12, 34)
     * $query->filterByFieldFloat(array('min' => 12)); // WHERE field_float > 12
     * </code>
     *
     * @param     mixed $fieldFloat The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTestClassQuery The current query, for fluid interface
     */
    public function filterByFieldFloat($fieldFloat = null, $comparison = null)
    {
        if (is_array($fieldFloat)) {
            $useMinMax = false;
            if (isset($fieldFloat['min'])) {
                $this->addUsingAlias(TestClassTableMap::COL_FIELD_FLOAT, $fieldFloat['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fieldFloat['max'])) {
                $this->addUsingAlias(TestClassTableMap::COL_FIELD_FLOAT, $fieldFloat['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TestClassTableMap::COL_FIELD_FLOAT, $fieldFloat, $comparison);
    }

    /**
     * Filter the query on the field_timestamp column
     *
     * Example usage:
     * <code>
     * $query->filterByFieldTimestamp('2011-03-14'); // WHERE field_timestamp = '2011-03-14'
     * $query->filterByFieldTimestamp('now'); // WHERE field_timestamp = '2011-03-14'
     * $query->filterByFieldTimestamp(array('max' => 'yesterday')); // WHERE field_timestamp > '2011-03-13'
     * </code>
     *
     * @param     mixed $fieldTimestamp The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTestClassQuery The current query, for fluid interface
     */
    public function filterByFieldTimestamp($fieldTimestamp = null, $comparison = null)
    {
        if (is_array($fieldTimestamp)) {
            $useMinMax = false;
            if (isset($fieldTimestamp['min'])) {
                $this->addUsingAlias(TestClassTableMap::COL_FIELD_TIMESTAMP, $fieldTimestamp['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fieldTimestamp['max'])) {
                $this->addUsingAlias(TestClassTableMap::COL_FIELD_TIMESTAMP, $fieldTimestamp['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TestClassTableMap::COL_FIELD_TIMESTAMP, $fieldTimestamp, $comparison);
    }

    /**
     * Filter the query on the field_boolean column
     *
     * Example usage:
     * <code>
     * $query->filterByFieldBoolean(true); // WHERE field_boolean = true
     * $query->filterByFieldBoolean('yes'); // WHERE field_boolean = true
     * </code>
     *
     * @param     boolean|string $fieldBoolean The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTestClassQuery The current query, for fluid interface
     */
    public function filterByFieldBoolean($fieldBoolean = null, $comparison = null)
    {
        if (is_string($fieldBoolean)) {
            $fieldBoolean = in_array(strtolower($fieldBoolean), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(TestClassTableMap::COL_FIELD_BOOLEAN, $fieldBoolean, $comparison);
    }

    /**
     * Filter the query on the required_field column
     *
     * Example usage:
     * <code>
     * $query->filterByRequiredField('fooValue');   // WHERE required_field = 'fooValue'
     * $query->filterByRequiredField('%fooValue%'); // WHERE required_field LIKE '%fooValue%'
     * </code>
     *
     * @param     string $requiredField The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTestClassQuery The current query, for fluid interface
     */
    public function filterByRequiredField($requiredField = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($requiredField)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $requiredField)) {
                $requiredField = str_replace('*', '%', $requiredField);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TestClassTableMap::COL_REQUIRED_FIELD, $requiredField, $comparison);
    }

    /**
     * Filter the query on the unrequired_field column
     *
     * Example usage:
     * <code>
     * $query->filterByUnrequiredField('fooValue');   // WHERE unrequired_field = 'fooValue'
     * $query->filterByUnrequiredField('%fooValue%'); // WHERE unrequired_field LIKE '%fooValue%'
     * </code>
     *
     * @param     string $unrequiredField The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTestClassQuery The current query, for fluid interface
     */
    public function filterByUnrequiredField($unrequiredField = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($unrequiredField)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $unrequiredField)) {
                $unrequiredField = str_replace('*', '%', $unrequiredField);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TestClassTableMap::COL_UNREQUIRED_FIELD, $unrequiredField, $comparison);
    }

    /**
     * Filter the query on the encrypted_field column
     *
     * @param     mixed $encryptedField The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTestClassQuery The current query, for fluid interface
     */
    public function filterByEncryptedField($encryptedField = null, $comparison = null)
    {

        return $this->addUsingAlias(TestClassTableMap::COL_ENCRYPTED_FIELD, $encryptedField, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildTestClass $testClass Object to remove from the list of results
     *
     * @return $this|ChildTestClassQuery The current query, for fluid interface
     */
    public function prune($testClass = null)
    {
        if ($testClass) {
            $this->addUsingAlias(TestClassTableMap::COL_ID, $testClass->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the test_class table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TestClassTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            TestClassTableMap::clearInstancePool();
            TestClassTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TestClassTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(TestClassTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            TestClassTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            TestClassTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // TestClassQuery
