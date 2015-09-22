<?php

namespace UWDOEMTest\Base;

use \Exception;
use \PDO;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use UWDOEMTest\TestClassTwo as ChildTestClassTwo;
use UWDOEMTest\TestClassTwoQuery as ChildTestClassTwoQuery;
use UWDOEMTest\Map\TestClassTwoTableMap;

/**
 * Base class that represents a query for the 'test_class_two' table.
 *
 * 
 *
 * @method     ChildTestClassTwoQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildTestClassTwoQuery orderByFieldVarchar($order = Criteria::ASC) Order by the field_varchar column
 * @method     ChildTestClassTwoQuery orderByTestClassId($order = Criteria::ASC) Order by the test_class_id column
 *
 * @method     ChildTestClassTwoQuery groupById() Group by the id column
 * @method     ChildTestClassTwoQuery groupByFieldVarchar() Group by the field_varchar column
 * @method     ChildTestClassTwoQuery groupByTestClassId() Group by the test_class_id column
 *
 * @method     ChildTestClassTwoQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildTestClassTwoQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildTestClassTwoQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildTestClassTwoQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildTestClassTwoQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildTestClassTwoQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildTestClassTwoQuery leftJoinTestClass($relationAlias = null) Adds a LEFT JOIN clause to the query using the TestClass relation
 * @method     ChildTestClassTwoQuery rightJoinTestClass($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TestClass relation
 * @method     ChildTestClassTwoQuery innerJoinTestClass($relationAlias = null) Adds a INNER JOIN clause to the query using the TestClass relation
 *
 * @method     ChildTestClassTwoQuery joinWithTestClass($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the TestClass relation
 *
 * @method     ChildTestClassTwoQuery leftJoinWithTestClass() Adds a LEFT JOIN clause and with to the query using the TestClass relation
 * @method     ChildTestClassTwoQuery rightJoinWithTestClass() Adds a RIGHT JOIN clause and with to the query using the TestClass relation
 * @method     ChildTestClassTwoQuery innerJoinWithTestClass() Adds a INNER JOIN clause and with to the query using the TestClass relation
 *
 * @method     \UWDOEMTest\TestClassQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildTestClassTwo findOne(ConnectionInterface $con = null) Return the first ChildTestClassTwo matching the query
 * @method     ChildTestClassTwo findOneOrCreate(ConnectionInterface $con = null) Return the first ChildTestClassTwo matching the query, or a new ChildTestClassTwo object populated from the query conditions when no match is found
 *
 * @method     ChildTestClassTwo findOneById(int $id) Return the first ChildTestClassTwo filtered by the id column
 * @method     ChildTestClassTwo findOneByFieldVarchar(string $field_varchar) Return the first ChildTestClassTwo filtered by the field_varchar column
 * @method     ChildTestClassTwo findOneByTestClassId(int $test_class_id) Return the first ChildTestClassTwo filtered by the test_class_id column *

 * @method     ChildTestClassTwo requirePk($key, ConnectionInterface $con = null) Return the ChildTestClassTwo by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTestClassTwo requireOne(ConnectionInterface $con = null) Return the first ChildTestClassTwo matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTestClassTwo requireOneById(int $id) Return the first ChildTestClassTwo filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTestClassTwo requireOneByFieldVarchar(string $field_varchar) Return the first ChildTestClassTwo filtered by the field_varchar column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTestClassTwo requireOneByTestClassId(int $test_class_id) Return the first ChildTestClassTwo filtered by the test_class_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTestClassTwo[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildTestClassTwo objects based on current ModelCriteria
 * @method     ChildTestClassTwo[]|ObjectCollection findById(int $id) Return ChildTestClassTwo objects filtered by the id column
 * @method     ChildTestClassTwo[]|ObjectCollection findByFieldVarchar(string $field_varchar) Return ChildTestClassTwo objects filtered by the field_varchar column
 * @method     ChildTestClassTwo[]|ObjectCollection findByTestClassId(int $test_class_id) Return ChildTestClassTwo objects filtered by the test_class_id column
 * @method     ChildTestClassTwo[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class TestClassTwoQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \UWDOEMTest\Base\TestClassTwoQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'uwdoem_test', $modelName = '\\UWDOEMTest\\TestClassTwo', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildTestClassTwoQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildTestClassTwoQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildTestClassTwoQuery) {
            return $criteria;
        }
        $query = new ChildTestClassTwoQuery();
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
     * @return ChildTestClassTwo|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = TestClassTwoTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TestClassTwoTableMap::DATABASE_NAME);
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
     * @return ChildTestClassTwo A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, field_varchar, test_class_id FROM test_class_two WHERE id = :p0';
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
            /** @var ChildTestClassTwo $obj */
            $obj = new ChildTestClassTwo();
            $obj->hydrate($row);
            TestClassTwoTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildTestClassTwo|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildTestClassTwoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(TestClassTwoTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildTestClassTwoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(TestClassTwoTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildTestClassTwoQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(TestClassTwoTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(TestClassTwoTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TestClassTwoTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the field_varchar column
     *
     * Example usage:
     * <code>
     * $query->filterByFieldVarchar('fooValue');   // WHERE field_varchar = 'fooValue'
     * $query->filterByFieldVarchar('%fooValue%'); // WHERE field_varchar LIKE '%fooValue%'
     * </code>
     *
     * @param     string $fieldVarchar The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTestClassTwoQuery The current query, for fluid interface
     */
    public function filterByFieldVarchar($fieldVarchar = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($fieldVarchar)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $fieldVarchar)) {
                $fieldVarchar = str_replace('*', '%', $fieldVarchar);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TestClassTwoTableMap::COL_FIELD_VARCHAR, $fieldVarchar, $comparison);
    }

    /**
     * Filter the query on the test_class_id column
     *
     * Example usage:
     * <code>
     * $query->filterByTestClassId(1234); // WHERE test_class_id = 1234
     * $query->filterByTestClassId(array(12, 34)); // WHERE test_class_id IN (12, 34)
     * $query->filterByTestClassId(array('min' => 12)); // WHERE test_class_id > 12
     * </code>
     *
     * @see       filterByTestClass()
     *
     * @param     mixed $testClassId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTestClassTwoQuery The current query, for fluid interface
     */
    public function filterByTestClassId($testClassId = null, $comparison = null)
    {
        if (is_array($testClassId)) {
            $useMinMax = false;
            if (isset($testClassId['min'])) {
                $this->addUsingAlias(TestClassTwoTableMap::COL_TEST_CLASS_ID, $testClassId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($testClassId['max'])) {
                $this->addUsingAlias(TestClassTwoTableMap::COL_TEST_CLASS_ID, $testClassId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TestClassTwoTableMap::COL_TEST_CLASS_ID, $testClassId, $comparison);
    }

    /**
     * Filter the query by a related \UWDOEMTest\TestClass object
     *
     * @param \UWDOEMTest\TestClass|ObjectCollection $testClass The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildTestClassTwoQuery The current query, for fluid interface
     */
    public function filterByTestClass($testClass, $comparison = null)
    {
        if ($testClass instanceof \UWDOEMTest\TestClass) {
            return $this
                ->addUsingAlias(TestClassTwoTableMap::COL_TEST_CLASS_ID, $testClass->getId(), $comparison);
        } elseif ($testClass instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TestClassTwoTableMap::COL_TEST_CLASS_ID, $testClass->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByTestClass() only accepts arguments of type \UWDOEMTest\TestClass or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the TestClass relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTestClassTwoQuery The current query, for fluid interface
     */
    public function joinTestClass($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('TestClass');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'TestClass');
        }

        return $this;
    }

    /**
     * Use the TestClass relation TestClass object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \UWDOEMTest\TestClassQuery A secondary query class using the current class as primary query
     */
    public function useTestClassQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinTestClass($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'TestClass', '\UWDOEMTest\TestClassQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildTestClassTwo $testClassTwo Object to remove from the list of results
     *
     * @return $this|ChildTestClassTwoQuery The current query, for fluid interface
     */
    public function prune($testClassTwo = null)
    {
        if ($testClassTwo) {
            $this->addUsingAlias(TestClassTwoTableMap::COL_ID, $testClassTwo->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the test_class_two table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TestClassTwoTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            TestClassTwoTableMap::clearInstancePool();
            TestClassTwoTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(TestClassTwoTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(TestClassTwoTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            TestClassTwoTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            TestClassTwoTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // TestClassTwoQuery
