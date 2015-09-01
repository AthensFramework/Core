<?php

namespace UWDOEMTest\Map;

use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;
use UWDOEMTest\TestClass;
use UWDOEMTest\TestClassQuery;


/**
 * This class defines the structure of the 'test_class' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class TestClassTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'UWDOEMTest.Map.TestClassTableMap';

    /**
     * Those columns encrypted by UWDOEM/Encryption
     */
    const ENCRYPTED_COLUMNS = 'EncryptedField';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'uwdoem_test';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'test_class';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\UWDOEMTest\\TestClass';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'UWDOEMTest.TestClass';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 10;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 10;

    /**
     * the column name for the id field
     */
    const COL_ID = 'test_class.id';

    /**
     * the column name for the field_small_varchar field
     */
    const COL_FIELD_SMALL_VARCHAR = 'test_class.field_small_varchar';

    /**
     * the column name for the field_large_varchar field
     */
    const COL_FIELD_LARGE_VARCHAR = 'test_class.field_large_varchar';

    /**
     * the column name for the field_integer field
     */
    const COL_FIELD_INTEGER = 'test_class.field_integer';

    /**
     * the column name for the field_float field
     */
    const COL_FIELD_FLOAT = 'test_class.field_float';

    /**
     * the column name for the field_timestamp field
     */
    const COL_FIELD_TIMESTAMP = 'test_class.field_timestamp';

    /**
     * the column name for the field_boolean field
     */
    const COL_FIELD_BOOLEAN = 'test_class.field_boolean';

    /**
     * the column name for the required_field field
     */
    const COL_REQUIRED_FIELD = 'test_class.required_field';

    /**
     * the column name for the unrequired_field field
     */
    const COL_UNREQUIRED_FIELD = 'test_class.unrequired_field';

    /**
     * the column name for the encrypted_field field
     */
    const COL_ENCRYPTED_FIELD = 'test_class.encrypted_field';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'FieldSmallVarchar', 'FieldLargeVarchar', 'FieldInteger', 'FieldFloat', 'FieldTimestamp', 'FieldBoolean', 'RequiredField', 'UnrequiredField', 'EncryptedField', ),
        self::TYPE_CAMELNAME     => array('id', 'fieldSmallVarchar', 'fieldLargeVarchar', 'fieldInteger', 'fieldFloat', 'fieldTimestamp', 'fieldBoolean', 'requiredField', 'unrequiredField', 'encryptedField', ),
        self::TYPE_COLNAME       => array(TestClassTableMap::COL_ID, TestClassTableMap::COL_FIELD_SMALL_VARCHAR, TestClassTableMap::COL_FIELD_LARGE_VARCHAR, TestClassTableMap::COL_FIELD_INTEGER, TestClassTableMap::COL_FIELD_FLOAT, TestClassTableMap::COL_FIELD_TIMESTAMP, TestClassTableMap::COL_FIELD_BOOLEAN, TestClassTableMap::COL_REQUIRED_FIELD, TestClassTableMap::COL_UNREQUIRED_FIELD, TestClassTableMap::COL_ENCRYPTED_FIELD, ),
        self::TYPE_FIELDNAME     => array('id', 'field_small_varchar', 'field_large_varchar', 'field_integer', 'field_float', 'field_timestamp', 'field_boolean', 'required_field', 'unrequired_field', 'encrypted_field', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'FieldSmallVarchar' => 1, 'FieldLargeVarchar' => 2, 'FieldInteger' => 3, 'FieldFloat' => 4, 'FieldTimestamp' => 5, 'FieldBoolean' => 6, 'RequiredField' => 7, 'UnrequiredField' => 8, 'EncryptedField' => 9, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'fieldSmallVarchar' => 1, 'fieldLargeVarchar' => 2, 'fieldInteger' => 3, 'fieldFloat' => 4, 'fieldTimestamp' => 5, 'fieldBoolean' => 6, 'requiredField' => 7, 'unrequiredField' => 8, 'encryptedField' => 9, ),
        self::TYPE_COLNAME       => array(TestClassTableMap::COL_ID => 0, TestClassTableMap::COL_FIELD_SMALL_VARCHAR => 1, TestClassTableMap::COL_FIELD_LARGE_VARCHAR => 2, TestClassTableMap::COL_FIELD_INTEGER => 3, TestClassTableMap::COL_FIELD_FLOAT => 4, TestClassTableMap::COL_FIELD_TIMESTAMP => 5, TestClassTableMap::COL_FIELD_BOOLEAN => 6, TestClassTableMap::COL_REQUIRED_FIELD => 7, TestClassTableMap::COL_UNREQUIRED_FIELD => 8, TestClassTableMap::COL_ENCRYPTED_FIELD => 9, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'field_small_varchar' => 1, 'field_large_varchar' => 2, 'field_integer' => 3, 'field_float' => 4, 'field_timestamp' => 5, 'field_boolean' => 6, 'required_field' => 7, 'unrequired_field' => 8, 'encrypted_field' => 9, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('test_class');
        $this->setPhpName('TestClass');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\UWDOEMTest\\TestClass');
        $this->setPackage('UWDOEMTest');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('field_small_varchar', 'FieldSmallVarchar', 'VARCHAR', false, 7, null);
        $this->addColumn('field_large_varchar', 'FieldLargeVarchar', 'VARCHAR', false, 15000, null);
        $this->addColumn('field_integer', 'FieldInteger', 'INTEGER', false, null, null);
        $this->addColumn('field_float', 'FieldFloat', 'FLOAT', false, null, null);
        $this->addColumn('field_timestamp', 'FieldTimestamp', 'TIMESTAMP', false, null, null);
        $this->addColumn('field_boolean', 'FieldBoolean', 'BOOLEAN', false, 1, null);
        $this->addColumn('required_field', 'RequiredField', 'VARCHAR', true, 7, null);
        $this->addColumn('unrequired_field', 'UnrequiredField', 'VARCHAR', false, 7, null);
        $this->addColumn('encrypted_field', 'EncryptedField', 'VARBINARY', false, 7, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
    } // buildRelations()

    /**
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array Associative array (name => parameters) of behaviors
     */
    public function getBehaviors()
    {
        return array(
            'encrypt_encrypted_field' => array('column_name' => 'encrypted_field', 'searchable' => '', 'sortable' => '', ),
        );
    } // getBehaviors()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }
    
    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? TestClassTableMap::CLASS_DEFAULT : TestClassTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (TestClass object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = TestClassTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = TestClassTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + TestClassTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = TestClassTableMap::OM_CLASS;
            /** @var TestClass $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            TestClassTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();
    
        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = TestClassTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = TestClassTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var TestClass $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                TestClassTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(TestClassTableMap::COL_ID);
            $criteria->addSelectColumn(TestClassTableMap::COL_FIELD_SMALL_VARCHAR);
            $criteria->addSelectColumn(TestClassTableMap::COL_FIELD_LARGE_VARCHAR);
            $criteria->addSelectColumn(TestClassTableMap::COL_FIELD_INTEGER);
            $criteria->addSelectColumn(TestClassTableMap::COL_FIELD_FLOAT);
            $criteria->addSelectColumn(TestClassTableMap::COL_FIELD_TIMESTAMP);
            $criteria->addSelectColumn(TestClassTableMap::COL_FIELD_BOOLEAN);
            $criteria->addSelectColumn(TestClassTableMap::COL_REQUIRED_FIELD);
            $criteria->addSelectColumn(TestClassTableMap::COL_UNREQUIRED_FIELD);
            $criteria->addSelectColumn(TestClassTableMap::COL_ENCRYPTED_FIELD);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.field_small_varchar');
            $criteria->addSelectColumn($alias . '.field_large_varchar');
            $criteria->addSelectColumn($alias . '.field_integer');
            $criteria->addSelectColumn($alias . '.field_float');
            $criteria->addSelectColumn($alias . '.field_timestamp');
            $criteria->addSelectColumn($alias . '.field_boolean');
            $criteria->addSelectColumn($alias . '.required_field');
            $criteria->addSelectColumn($alias . '.unrequired_field');
            $criteria->addSelectColumn($alias . '.encrypted_field');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(TestClassTableMap::DATABASE_NAME)->getTable(TestClassTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(TestClassTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(TestClassTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new TestClassTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a TestClass or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or TestClass object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TestClassTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \UWDOEMTest\TestClass) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(TestClassTableMap::DATABASE_NAME);
            $criteria->add(TestClassTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = TestClassQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            TestClassTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                TestClassTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the test_class table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return TestClassQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a TestClass or Criteria object.
     *
     * @param mixed               $criteria Criteria or TestClass object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TestClassTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from TestClass object
        }

        if ($criteria->containsKey(TestClassTableMap::COL_ID) && $criteria->keyContainsValue(TestClassTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.TestClassTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = TestClassQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // TestClassTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
TestClassTableMap::buildTableMap();
