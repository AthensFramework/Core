<?php

namespace AthensTest\Base;

use \DateTime;
use \Exception;
use \PDO;
use AthensTest\TestClass as ChildTestClass;
use AthensTest\TestClassQuery as ChildTestClassQuery;
use AthensTest\TestClassTwo as ChildTestClassTwo;
use AthensTest\TestClassTwoQuery as ChildTestClassTwoQuery;
use AthensTest\Map\TestClassTableMap;
use AthensTest\Map\TestClassTwoTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\QueryWrapperInterface;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'test_class' table.
 *
 * 
 *
* @package    propel.generator.AthensTest.Base
*/
abstract class TestClass implements ActiveRecordInterface 
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\AthensTest\\Map\\TestClassTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id field.
     * 
     * @var        int
     */
    protected $id;

    /**
     * The value for the field_small_varchar field.
     * 
     * @var        string
     */
    protected $field_small_varchar;

    /**
     * The value for the field_large_varchar field.
     * 
     * @var        string
     */
    protected $field_large_varchar;

    /**
     * The value for the field_integer field.
     * 
     * @var        int
     */
    protected $field_integer;

    /**
     * The value for the field_float field.
     * 
     * @var        double
     */
    protected $field_float;

    /**
     * The value for the field_timestamp field.
     * 
     * @var        \DateTime
     */
    protected $field_timestamp;

    /**
     * The value for the field_boolean field.
     * 
     * @var        boolean
     */
    protected $field_boolean;

    /**
     * The value for the required_field field.
     * 
     * @var        string
     */
    protected $required_field;

    /**
     * The value for the unrequired_field field.
     * 
     * @var        string
     */
    protected $unrequired_field;

    /**
     * The value for the encrypted_field field.
     * 
     * @var        string
     */
    protected $encrypted_field;

    /**
     * @var        ObjectCollection|ChildTestClassTwo[] Collection to store aggregation of ChildTestClassTwo objects.
     */
    protected $collTestClassTwos;
    protected $collTestClassTwosPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildTestClassTwo[]
     */
    protected $testClassTwosScheduledForDeletion = null;

    /**
     * Initializes internal state of AthensTest\Base\TestClass object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>TestClass</code> instance.  If
     * <code>obj</code> is an instance of <code>TestClass</code>, delegates to
     * <code>equals(TestClass)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|TestClass The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));
        
        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }
        
        return $propertyNames;
    }

    /**
     * Get the [id] column value.
     * 
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [field_small_varchar] column value.
     * 
     * @return string
     */
    public function getFieldSmallVarchar()
    {
        return $this->field_small_varchar;
    }

    /**
     * Get the [field_large_varchar] column value.
     * 
     * @return string
     */
    public function getFieldLargeVarchar()
    {
        return $this->field_large_varchar;
    }

    /**
     * Get the [field_integer] column value.
     * 
     * @return int
     */
    public function getFieldInteger()
    {
        return $this->field_integer;
    }

    /**
     * Get the [field_float] column value.
     * 
     * @return double
     */
    public function getFieldFloat()
    {
        return $this->field_float;
    }

    /**
     * Get the [optionally formatted] temporal [field_timestamp] column value.
     * 
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getFieldTimestamp($format = NULL)
    {
        if ($format === null) {
            return $this->field_timestamp;
        } else {
            return $this->field_timestamp instanceof \DateTime ? $this->field_timestamp->format($format) : null;
        }
    }

    /**
     * Get the [field_boolean] column value.
     * 
     * @return boolean
     */
    public function getFieldBoolean()
    {
        return $this->field_boolean;
    }

    /**
     * Get the [field_boolean] column value.
     * 
     * @return boolean
     */
    public function isFieldBoolean()
    {
        return $this->getFieldBoolean();
    }

    /**
     * Get the [required_field] column value.
     * 
     * @return string
     */
    public function getRequiredField()
    {
        return $this->required_field;
    }

    /**
     * Get the [unrequired_field] column value.
     * 
     * @return string
     */
    public function getUnrequiredField()
    {
        return $this->unrequired_field;
    }

    /**
     * Get the [encrypted_field] column value.
     * 
     * @return string
     */
    public function getEncryptedField()
    {
        // Decrypt the variable, per \Athens\Encryption\EncryptionBehavior.
        $fieldValue = $this->encrypted_field;
        if (is_resource($fieldValue) && get_resource_type($fieldValue) === "stream") {
            $fieldValue = \Athens\Encryption\Cipher::getInstance()->decryptStream($fieldValue);
        }
        return $fieldValue;
    }

    /**
     * Set the value of [id] column.
     * 
     * @param int $v new value
     * @return $this|\AthensTest\TestClass The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[TestClassTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [field_small_varchar] column.
     * 
     * @param string $v new value
     * @return $this|\AthensTest\TestClass The current object (for fluent API support)
     */
    public function setFieldSmallVarchar($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->field_small_varchar !== $v) {
            $this->field_small_varchar = $v;
            $this->modifiedColumns[TestClassTableMap::COL_FIELD_SMALL_VARCHAR] = true;
        }

        return $this;
    } // setFieldSmallVarchar()

    /**
     * Set the value of [field_large_varchar] column.
     * 
     * @param string $v new value
     * @return $this|\AthensTest\TestClass The current object (for fluent API support)
     */
    public function setFieldLargeVarchar($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->field_large_varchar !== $v) {
            $this->field_large_varchar = $v;
            $this->modifiedColumns[TestClassTableMap::COL_FIELD_LARGE_VARCHAR] = true;
        }

        return $this;
    } // setFieldLargeVarchar()

    /**
     * Set the value of [field_integer] column.
     * 
     * @param int $v new value
     * @return $this|\AthensTest\TestClass The current object (for fluent API support)
     */
    public function setFieldInteger($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->field_integer !== $v) {
            $this->field_integer = $v;
            $this->modifiedColumns[TestClassTableMap::COL_FIELD_INTEGER] = true;
        }

        return $this;
    } // setFieldInteger()

    /**
     * Set the value of [field_float] column.
     * 
     * @param double $v new value
     * @return $this|\AthensTest\TestClass The current object (for fluent API support)
     */
    public function setFieldFloat($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->field_float !== $v) {
            $this->field_float = $v;
            $this->modifiedColumns[TestClassTableMap::COL_FIELD_FLOAT] = true;
        }

        return $this;
    } // setFieldFloat()

    /**
     * Sets the value of [field_timestamp] column to a normalized version of the date/time value specified.
     * 
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\AthensTest\TestClass The current object (for fluent API support)
     */
    public function setFieldTimestamp($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->field_timestamp !== null || $dt !== null) {
            if ($this->field_timestamp === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->field_timestamp->format("Y-m-d H:i:s")) {
                $this->field_timestamp = $dt === null ? null : clone $dt;
                $this->modifiedColumns[TestClassTableMap::COL_FIELD_TIMESTAMP] = true;
            }
        } // if either are not null

        return $this;
    } // setFieldTimestamp()

    /**
     * Sets the value of the [field_boolean] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * 
     * @param  boolean|integer|string $v The new value
     * @return $this|\AthensTest\TestClass The current object (for fluent API support)
     */
    public function setFieldBoolean($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->field_boolean !== $v) {
            $this->field_boolean = $v;
            $this->modifiedColumns[TestClassTableMap::COL_FIELD_BOOLEAN] = true;
        }

        return $this;
    } // setFieldBoolean()

    /**
     * Set the value of [required_field] column.
     * 
     * @param string $v new value
     * @return $this|\AthensTest\TestClass The current object (for fluent API support)
     */
    public function setRequiredField($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->required_field !== $v) {
            $this->required_field = $v;
            $this->modifiedColumns[TestClassTableMap::COL_REQUIRED_FIELD] = true;
        }

        return $this;
    } // setRequiredField()

    /**
     * Set the value of [unrequired_field] column.
     * 
     * @param string $v new value
     * @return $this|\AthensTest\TestClass The current object (for fluent API support)
     */
    public function setUnrequiredField($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->unrequired_field !== $v) {
            $this->unrequired_field = $v;
            $this->modifiedColumns[TestClassTableMap::COL_UNREQUIRED_FIELD] = true;
        }

        return $this;
    } // setUnrequiredField()

    /**
     * Set the value of [encrypted_field] column.
     * 
     * @param string $v new value
     * @return $this|\AthensTest\TestClass The current object (for fluent API support)
     */
    public function setEncryptedField($v)
    {
        // Encrypt the variable, per \Athens\Encryption\EncryptionBehavior.
        $v = \Athens\Encryption\Cipher::getInstance()->encrypt($v);

        // Because BLOB columns are streams in PDO we have to assume that they are
        // always modified when a new value is passed in.  For example, the contents
        // of the stream itself may have changed externally.
        if (!is_resource($v) && $v !== null) {
            $this->encrypted_field = fopen('php://memory', 'r+');
            fwrite($this->encrypted_field, $v);
            rewind($this->encrypted_field);
        } else { // it's already a stream
            $this->encrypted_field = $v;
        }
        $this->modifiedColumns[TestClassTableMap::COL_ENCRYPTED_FIELD] = true;

        return $this;
    } // setEncryptedField()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : TestClassTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : TestClassTableMap::translateFieldName('FieldSmallVarchar', TableMap::TYPE_PHPNAME, $indexType)];
            $this->field_small_varchar = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : TestClassTableMap::translateFieldName('FieldLargeVarchar', TableMap::TYPE_PHPNAME, $indexType)];
            $this->field_large_varchar = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : TestClassTableMap::translateFieldName('FieldInteger', TableMap::TYPE_PHPNAME, $indexType)];
            $this->field_integer = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : TestClassTableMap::translateFieldName('FieldFloat', TableMap::TYPE_PHPNAME, $indexType)];
            $this->field_float = (null !== $col) ? (double) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : TestClassTableMap::translateFieldName('FieldTimestamp', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->field_timestamp = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : TestClassTableMap::translateFieldName('FieldBoolean', TableMap::TYPE_PHPNAME, $indexType)];
            $this->field_boolean = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : TestClassTableMap::translateFieldName('RequiredField', TableMap::TYPE_PHPNAME, $indexType)];
            $this->required_field = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : TestClassTableMap::translateFieldName('UnrequiredField', TableMap::TYPE_PHPNAME, $indexType)];
            $this->unrequired_field = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : TestClassTableMap::translateFieldName('EncryptedField', TableMap::TYPE_PHPNAME, $indexType)];
            if (null !== $col) {
                $this->encrypted_field = fopen('php://memory', 'r+');
                fwrite($this->encrypted_field, $col);
                rewind($this->encrypted_field);
            } else {
                $this->encrypted_field = null;
            }
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 10; // 10 = TestClassTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\AthensTest\\TestClass'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TestClassTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildTestClassQuery::create(null, $this->buildPkeyCriteria())->setFormatter(QueryWrapperInterface::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collTestClassTwos = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see TestClass::setDeleted()
     * @see TestClass::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(TestClassTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildTestClassQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(TestClassTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                TestClassTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                // Rewind the encrypted_field LOB column, since PDO does not rewind after inserting value.
                if ($this->encrypted_field !== null && is_resource($this->encrypted_field)) {
                    rewind($this->encrypted_field);
                }

                $this->resetModified();
            }

            if ($this->testClassTwosScheduledForDeletion !== null) {
                if (!$this->testClassTwosScheduledForDeletion->isEmpty()) {
                    foreach ($this->testClassTwosScheduledForDeletion as $testClassTwo) {
                        // need to save related object because we set the relation to null
                        $testClassTwo->save($con);
                    }
                    $this->testClassTwosScheduledForDeletion = null;
                }
            }

            if ($this->collTestClassTwos !== null) {
                foreach ($this->collTestClassTwos as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[TestClassTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . TestClassTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(TestClassTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(TestClassTableMap::COL_FIELD_SMALL_VARCHAR)) {
            $modifiedColumns[':p' . $index++]  = 'field_small_varchar';
        }
        if ($this->isColumnModified(TestClassTableMap::COL_FIELD_LARGE_VARCHAR)) {
            $modifiedColumns[':p' . $index++]  = 'field_large_varchar';
        }
        if ($this->isColumnModified(TestClassTableMap::COL_FIELD_INTEGER)) {
            $modifiedColumns[':p' . $index++]  = 'field_integer';
        }
        if ($this->isColumnModified(TestClassTableMap::COL_FIELD_FLOAT)) {
            $modifiedColumns[':p' . $index++]  = 'field_float';
        }
        if ($this->isColumnModified(TestClassTableMap::COL_FIELD_TIMESTAMP)) {
            $modifiedColumns[':p' . $index++]  = 'field_timestamp';
        }
        if ($this->isColumnModified(TestClassTableMap::COL_FIELD_BOOLEAN)) {
            $modifiedColumns[':p' . $index++]  = 'field_boolean';
        }
        if ($this->isColumnModified(TestClassTableMap::COL_REQUIRED_FIELD)) {
            $modifiedColumns[':p' . $index++]  = 'required_field';
        }
        if ($this->isColumnModified(TestClassTableMap::COL_UNREQUIRED_FIELD)) {
            $modifiedColumns[':p' . $index++]  = 'unrequired_field';
        }
        if ($this->isColumnModified(TestClassTableMap::COL_ENCRYPTED_FIELD)) {
            $modifiedColumns[':p' . $index++]  = 'encrypted_field';
        }

        $sql = sprintf(
            'INSERT INTO test_class (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id':                        
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'field_small_varchar':                        
                        $stmt->bindValue($identifier, $this->field_small_varchar, PDO::PARAM_STR);
                        break;
                    case 'field_large_varchar':                        
                        $stmt->bindValue($identifier, $this->field_large_varchar, PDO::PARAM_STR);
                        break;
                    case 'field_integer':                        
                        $stmt->bindValue($identifier, $this->field_integer, PDO::PARAM_INT);
                        break;
                    case 'field_float':                        
                        $stmt->bindValue($identifier, $this->field_float, PDO::PARAM_STR);
                        break;
                    case 'field_timestamp':                        
                        $stmt->bindValue($identifier, $this->field_timestamp ? $this->field_timestamp->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'field_boolean':
                        $stmt->bindValue($identifier, (int) $this->field_boolean, PDO::PARAM_INT);
                        break;
                    case 'required_field':                        
                        $stmt->bindValue($identifier, $this->required_field, PDO::PARAM_STR);
                        break;
                    case 'unrequired_field':                        
                        $stmt->bindValue($identifier, $this->unrequired_field, PDO::PARAM_STR);
                        break;
                    case 'encrypted_field':                        
                        if (is_resource($this->encrypted_field)) {
                            rewind($this->encrypted_field);
                        }
                        $stmt->bindValue($identifier, $this->encrypted_field, PDO::PARAM_LOB);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = TestClassTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getFieldSmallVarchar();
                break;
            case 2:
                return $this->getFieldLargeVarchar();
                break;
            case 3:
                return $this->getFieldInteger();
                break;
            case 4:
                return $this->getFieldFloat();
                break;
            case 5:
                return $this->getFieldTimestamp();
                break;
            case 6:
                return $this->getFieldBoolean();
                break;
            case 7:
                return $this->getRequiredField();
                break;
            case 8:
                return $this->getUnrequiredField();
                break;
            case 9:
                return $this->getEncryptedField();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['TestClass'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['TestClass'][$this->hashCode()] = true;
        $keys = TestClassTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getFieldSmallVarchar(),
            $keys[2] => $this->getFieldLargeVarchar(),
            $keys[3] => $this->getFieldInteger(),
            $keys[4] => $this->getFieldFloat(),
            $keys[5] => $this->getFieldTimestamp(),
            $keys[6] => $this->getFieldBoolean(),
            $keys[7] => $this->getRequiredField(),
            $keys[8] => $this->getUnrequiredField(),
            $keys[9] => $this->getEncryptedField(),
        );
        if ($result[$keys[5]] instanceof \DateTime) {
            $result[$keys[5]] = $result[$keys[5]]->format('c');
        }
        
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }
        
        if ($includeForeignObjects) {
            if (null !== $this->collTestClassTwos) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'testClassTwos';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'test_class_twos';
                        break;
                    default:
                        $key = 'TestClassTwos';
                }
        
                $result[$key] = $this->collTestClassTwos->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\AthensTest\TestClass
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = TestClassTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\AthensTest\TestClass
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setFieldSmallVarchar($value);
                break;
            case 2:
                $this->setFieldLargeVarchar($value);
                break;
            case 3:
                $this->setFieldInteger($value);
                break;
            case 4:
                $this->setFieldFloat($value);
                break;
            case 5:
                $this->setFieldTimestamp($value);
                break;
            case 6:
                $this->setFieldBoolean($value);
                break;
            case 7:
                $this->setRequiredField($value);
                break;
            case 8:
                $this->setUnrequiredField($value);
                break;
            case 9:
                $this->setEncryptedField($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = TestClassTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setFieldSmallVarchar($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setFieldLargeVarchar($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setFieldInteger($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setFieldFloat($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setFieldTimestamp($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setFieldBoolean($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setRequiredField($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setUnrequiredField($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setEncryptedField($arr[$keys[9]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\AthensTest\TestClass The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(TestClassTableMap::DATABASE_NAME);

        if ($this->isColumnModified(TestClassTableMap::COL_ID)) {
            $criteria->add(TestClassTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(TestClassTableMap::COL_FIELD_SMALL_VARCHAR)) {
            $criteria->add(TestClassTableMap::COL_FIELD_SMALL_VARCHAR, $this->field_small_varchar);
        }
        if ($this->isColumnModified(TestClassTableMap::COL_FIELD_LARGE_VARCHAR)) {
            $criteria->add(TestClassTableMap::COL_FIELD_LARGE_VARCHAR, $this->field_large_varchar);
        }
        if ($this->isColumnModified(TestClassTableMap::COL_FIELD_INTEGER)) {
            $criteria->add(TestClassTableMap::COL_FIELD_INTEGER, $this->field_integer);
        }
        if ($this->isColumnModified(TestClassTableMap::COL_FIELD_FLOAT)) {
            $criteria->add(TestClassTableMap::COL_FIELD_FLOAT, $this->field_float);
        }
        if ($this->isColumnModified(TestClassTableMap::COL_FIELD_TIMESTAMP)) {
            $criteria->add(TestClassTableMap::COL_FIELD_TIMESTAMP, $this->field_timestamp);
        }
        if ($this->isColumnModified(TestClassTableMap::COL_FIELD_BOOLEAN)) {
            $criteria->add(TestClassTableMap::COL_FIELD_BOOLEAN, $this->field_boolean);
        }
        if ($this->isColumnModified(TestClassTableMap::COL_REQUIRED_FIELD)) {
            $criteria->add(TestClassTableMap::COL_REQUIRED_FIELD, $this->required_field);
        }
        if ($this->isColumnModified(TestClassTableMap::COL_UNREQUIRED_FIELD)) {
            $criteria->add(TestClassTableMap::COL_UNREQUIRED_FIELD, $this->unrequired_field);
        }
        if ($this->isColumnModified(TestClassTableMap::COL_ENCRYPTED_FIELD)) {
            $criteria->add(TestClassTableMap::COL_ENCRYPTED_FIELD, $this->encrypted_field);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildTestClassQuery::create();
        $criteria->add(TestClassTableMap::COL_ID, $this->id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }
        
    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \AthensTest\TestClass (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setFieldSmallVarchar($this->getFieldSmallVarchar());
        $copyObj->setFieldLargeVarchar($this->getFieldLargeVarchar());
        $copyObj->setFieldInteger($this->getFieldInteger());
        $copyObj->setFieldFloat($this->getFieldFloat());
        $copyObj->setFieldTimestamp($this->getFieldTimestamp());
        $copyObj->setFieldBoolean($this->getFieldBoolean());
        $copyObj->setRequiredField($this->getRequiredField());
        $copyObj->setUnrequiredField($this->getUnrequiredField());
        $copyObj->setEncryptedField($this->getEncryptedField());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getTestClassTwos() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addTestClassTwo($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \AthensTest\TestClass Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('TestClassTwo' == $relationName) {
            return $this->initTestClassTwos();
        }
    }

    /**
     * Clears out the collTestClassTwos collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addTestClassTwos()
     */
    public function clearTestClassTwos()
    {
        $this->collTestClassTwos = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collTestClassTwos collection loaded partially.
     */
    public function resetPartialTestClassTwos($v = true)
    {
        $this->collTestClassTwosPartial = $v;
    }

    /**
     * Initializes the collTestClassTwos collection.
     *
     * By default this just sets the collTestClassTwos collection to an empty array (like clearcollTestClassTwos());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initTestClassTwos($overrideExisting = true)
    {
        if (null !== $this->collTestClassTwos && !$overrideExisting) {
            return;
        }

        $collectionClassName = TestClassTwoTableMap::getTableMap()->getCollectionClassName();

        $this->collTestClassTwos = new $collectionClassName;
        $this->collTestClassTwos->setModel('\AthensTest\TestClassTwo');
    }

    /**
     * Gets an array of ChildTestClassTwo objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildTestClass is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildTestClassTwo[] List of ChildTestClassTwo objects
     * @throws PropelException
     */
    public function getTestClassTwos(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collTestClassTwosPartial && !$this->isNew();
        if (null === $this->collTestClassTwos || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collTestClassTwos) {
                // return empty collection
                $this->initTestClassTwos();
            } else {
                $collTestClassTwos = ChildTestClassTwoQuery::create(null, $criteria)
                    ->filterByTestClass($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collTestClassTwosPartial && count($collTestClassTwos)) {
                        $this->initTestClassTwos(false);

                        foreach ($collTestClassTwos as $obj) {
                            if (false == $this->collTestClassTwos->contains($obj)) {
                                $this->collTestClassTwos->append($obj);
                            }
                        }

                        $this->collTestClassTwosPartial = true;
                    }

                    return $collTestClassTwos;
                }

                if ($partial && $this->collTestClassTwos) {
                    foreach ($this->collTestClassTwos as $obj) {
                        if ($obj->isNew()) {
                            $collTestClassTwos[] = $obj;
                        }
                    }
                }

                $this->collTestClassTwos = $collTestClassTwos;
                $this->collTestClassTwosPartial = false;
            }
        }

        return $this->collTestClassTwos;
    }

    /**
     * Sets a collection of ChildTestClassTwo objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $testClassTwos A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildTestClass The current object (for fluent API support)
     */
    public function setTestClassTwos(Collection $testClassTwos, ConnectionInterface $con = null)
    {
        /** @var ChildTestClassTwo[] $testClassTwosToDelete */
        $testClassTwosToDelete = $this->getTestClassTwos(new Criteria(), $con)->diff($testClassTwos);

        
        $this->testClassTwosScheduledForDeletion = $testClassTwosToDelete;

        foreach ($testClassTwosToDelete as $testClassTwoRemoved) {
            $testClassTwoRemoved->setTestClass(null);
        }

        $this->collTestClassTwos = null;
        foreach ($testClassTwos as $testClassTwo) {
            $this->addTestClassTwo($testClassTwo);
        }

        $this->collTestClassTwos = $testClassTwos;
        $this->collTestClassTwosPartial = false;

        return $this;
    }

    /**
     * Returns the number of related TestClassTwo objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related TestClassTwo objects.
     * @throws PropelException
     */
    public function countTestClassTwos(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collTestClassTwosPartial && !$this->isNew();
        if (null === $this->collTestClassTwos || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTestClassTwos) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getTestClassTwos());
            }

            $query = ChildTestClassTwoQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByTestClass($this)
                ->count($con);
        }

        return count($this->collTestClassTwos);
    }

    /**
     * Method called to associate a ChildTestClassTwo object to this object
     * through the ChildTestClassTwo foreign key attribute.
     *
     * @param  ChildTestClassTwo $l ChildTestClassTwo
     * @return $this|\AthensTest\TestClass The current object (for fluent API support)
     */
    public function addTestClassTwo(ChildTestClassTwo $l)
    {
        if ($this->collTestClassTwos === null) {
            $this->initTestClassTwos();
            $this->collTestClassTwosPartial = true;
        }

        if (!$this->collTestClassTwos->contains($l)) {
            $this->doAddTestClassTwo($l);

            if ($this->testClassTwosScheduledForDeletion and $this->testClassTwosScheduledForDeletion->contains($l)) {
                $this->testClassTwosScheduledForDeletion->remove($this->testClassTwosScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildTestClassTwo $testClassTwo The ChildTestClassTwo object to add.
     */
    protected function doAddTestClassTwo(ChildTestClassTwo $testClassTwo)
    {
        $this->collTestClassTwos[]= $testClassTwo;
        $testClassTwo->setTestClass($this);
    }

    /**
     * @param  ChildTestClassTwo $testClassTwo The ChildTestClassTwo object to remove.
     * @return $this|ChildTestClass The current object (for fluent API support)
     */
    public function removeTestClassTwo(ChildTestClassTwo $testClassTwo)
    {
        if ($this->getTestClassTwos()->contains($testClassTwo)) {
            $pos = $this->collTestClassTwos->search($testClassTwo);
            $this->collTestClassTwos->remove($pos);
            if (null === $this->testClassTwosScheduledForDeletion) {
                $this->testClassTwosScheduledForDeletion = clone $this->collTestClassTwos;
                $this->testClassTwosScheduledForDeletion->clear();
            }
            $this->testClassTwosScheduledForDeletion[]= $testClassTwo;
            $testClassTwo->setTestClass(null);
        }

        return $this;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id = null;
        $this->field_small_varchar = null;
        $this->field_large_varchar = null;
        $this->field_integer = null;
        $this->field_float = null;
        $this->field_timestamp = null;
        $this->field_boolean = null;
        $this->required_field = null;
        $this->unrequired_field = null;
        $this->encrypted_field = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collTestClassTwos) {
                foreach ($this->collTestClassTwos as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collTestClassTwos = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(TestClassTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {

    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
