Athens\Core\Etc\ORMUtils
===============

Class ORMUtils provides static methods for interpreting and interfacing
with ORM entities.




* Class name: ORMUtils
* Namespace: Athens\Core\Etc





Properties
----------


### $db_type_to_field_type_association

    protected array $db_type_to_field_type_association = array("VARCHAR" => "text", "LONGVARCHAR" => "text", "INTEGER" => "text", "VARBINARY" => "text", "DATE" => "datetime", "TIMESTAMP" => "datetime", "BOOLEAN" => "boolean", "FLOAT" => "text")





* Visibility: **protected**
* This property is **static**.


Methods
-------


### makeFieldsFromObject

    array<mixed,\Athens\Core\Field\Field> Athens\Core\Etc\ORMUtils::makeFieldsFromObject(\Propel\Runtime\ActiveRecord\ActiveRecordInterface $object)





* Visibility: **public**
* This method is **static**.


#### Arguments
* $object **Propel\Runtime\ActiveRecord\ActiveRecordInterface**



### addBehaviorConstraintsToFields

    mixed Athens\Core\Etc\ORMUtils::addBehaviorConstraintsToFields(string $tableMapName, array<mixed,\Athens\Core\Field\FieldInterface> $fields, array $columns)





* Visibility: **public**
* This method is **static**.


#### Arguments
* $tableMapName **string**
* $fields **array&lt;mixed,\Athens\Core\Field\FieldInterface&gt;**
* $columns **array**



### makeNewObjectFromClassTableMapName

    \Propel\Runtime\ActiveRecord\ActiveRecordInterface Athens\Core\Etc\ORMUtils::makeNewObjectFromClassTableMapName(string $classTableMapName)

Produces a Propel2 object from the given class table map name.



* Visibility: **public**
* This method is **static**.


#### Arguments
* $classTableMapName **string**



### isEncrypted

    boolean Athens\Core\Etc\ORMUtils::isEncrypted(string $fieldName, string $classTableMapName)

Predicate that reports whether a given field name in a given class
table map name is under the athens/encryption Propel behavior.



* Visibility: **public**
* This method is **static**.


#### Arguments
* $fieldName **string**
* $classTableMapName **string**



### fillObjectFromFields

    void Athens\Core\Etc\ORMUtils::fillObjectFromFields(\Propel\Runtime\ActiveRecord\ActiveRecordInterface $object, array<mixed,\Athens\Core\Field\FieldInterface> $fields)

Fills an object's attributes from the validated data of an array
of fields.

Expects that $fields contains a set of $fieldName => $field pairs.

* Visibility: **public**
* This method is **static**.


#### Arguments
* $object **Propel\Runtime\ActiveRecord\ActiveRecordInterface**
* $fields **array&lt;mixed,\Athens\Core\Field\FieldInterface&gt;**



### makeFieldNamesFromObject

    array<mixed,string> Athens\Core\Etc\ORMUtils::makeFieldNamesFromObject(\Propel\Runtime\ActiveRecord\ActiveRecordInterface $object)





* Visibility: **protected**
* This method is **static**.


#### Arguments
* $object **Propel\Runtime\ActiveRecord\ActiveRecordInterface**



### getClassTableMap

    \Propel\Runtime\Map\TableMap Athens\Core\Etc\ORMUtils::getClassTableMap(string $classTableMapName)





* Visibility: **protected**
* This method is **static**.


#### Arguments
* $classTableMapName **string**



### getRelatedTableMap

    \Propel\Runtime\Map\TableMap Athens\Core\Etc\ORMUtils::getRelatedTableMap(string $tableName, string $fullyQualifiedTableMapName)

Return a Propel TableMap corresponding to a table within the same schema as
$fullyQualifiedTableMapName.

In some cases, a foreign table map within the same database as $this may not be initialized
by Propel. If we try to access a foreign table map using runtime introspection and it has
not yet been initialized, then Propel will throw a TableNotFoundException. This method
accesses the table map by access to its fully qualified class name, which it determines by
modifying $this->_classTableMapName.

* Visibility: **protected**
* This method is **static**.


#### Arguments
* $tableName **string** - &lt;p&gt;The SQL name of the related table for which you
                                            would like to retrieve a table map.&lt;/p&gt;
* $fullyQualifiedTableMapName **string** - &lt;p&gt;A fully qualified table map name.&lt;/p&gt;



### findParentTables

    array<mixed,\Propel\Runtime\Map\TableMap> Athens\Core\Etc\ORMUtils::findParentTables(string $classTableMapName)





* Visibility: **protected**
* This method is **static**.


#### Arguments
* $classTableMapName **string**



### getColumns

    array<mixed,\Propel\Runtime\Map\ColumnMap> Athens\Core\Etc\ORMUtils::getColumns(string $classTableMapName)





* Visibility: **protected**
* This method is **static**.


#### Arguments
* $classTableMapName **string**



### chooseFieldType

    string Athens\Core\Etc\ORMUtils::chooseFieldType(\Propel\Runtime\Map\ColumnMap $column)





* Visibility: **protected**
* This method is **static**.


#### Arguments
* $column **Propel\Runtime\Map\ColumnMap**



### makeFieldsFromColumns

    array<mixed,\Athens\Core\Field\Field> Athens\Core\Etc\ORMUtils::makeFieldsFromColumns(array<mixed,\Propel\Runtime\Map\ColumnMap> $columns)





* Visibility: **protected**
* This method is **static**.


#### Arguments
* $columns **array&lt;mixed,\Propel\Runtime\Map\ColumnMap&gt;**



### makeFieldsFromClassTableMapName

    array<mixed,\Athens\Core\Field\FieldInterface> Athens\Core\Etc\ORMUtils::makeFieldsFromClassTableMapName(string $classTableMapName)





* Visibility: **protected**
* This method is **static**.


#### Arguments
* $classTableMapName **string**



### getPhpNameFromObject

    string Athens\Core\Etc\ORMUtils::getPhpNameFromObject(\Propel\Runtime\ActiveRecord\ActiveRecordInterface $object)





* Visibility: **protected**
* This method is **static**.


#### Arguments
* $object **Propel\Runtime\ActiveRecord\ActiveRecordInterface**



### getObjectClass

    string Athens\Core\Etc\ORMUtils::getObjectClass(string $classTableMapName)





* Visibility: **protected**
* This method is **static**.


#### Arguments
* $classTableMapName **string**



### createQuery

    \Propel\Runtime\ActiveQuery\PropelQuery Athens\Core\Etc\ORMUtils::createQuery(string $classTableMapName)

Return a Propel ActiveQuery object corresponding to $this->_classTableMapName



* Visibility: **protected**
* This method is **static**.


#### Arguments
* $classTableMapName **string**



### baseFindAmongInheritance

    array<mixed,\Propel\Runtime\ActiveRecord\ActiveRecordInterface>|\Propel\Runtime\ActiveRecord\ActiveRecordInterface Athens\Core\Etc\ORMUtils::baseFindAmongInheritance(string $classTableMapName, string $fieldPhpName, mixed $value, \Athens\Core\Etc\"find"|\Athens\Core\Etc\"findOne" $findType)





* Visibility: **protected**
* This method is **static**.


#### Arguments
* $classTableMapName **string**
* $fieldPhpName **string**
* $value **mixed**
* $findType **Athens\Core\Etc\&quot;find&quot;|Athens\Core\Etc\&quot;findOne&quot;**



### findByAmongInheritance

    array<mixed,\Propel\Runtime\ActiveRecord\ActiveRecordInterface> Athens\Core\Etc\ORMUtils::findByAmongInheritance(string $classTableMapName, string $fieldPhpName, mixed $value)





* Visibility: **protected**
* This method is **static**.


#### Arguments
* $classTableMapName **string**
* $fieldPhpName **string**
* $value **mixed**



### findOneByAmongInheritance

    array<mixed,\Propel\Runtime\ActiveRecord\ActiveRecordInterface> Athens\Core\Etc\ORMUtils::findOneByAmongInheritance(string $classTableMapName, string $fieldPhpName, mixed $value)





* Visibility: **protected**
* This method is **static**.


#### Arguments
* $classTableMapName **string**
* $fieldPhpName **string**
* $value **mixed**



### getObjectById

    \Propel\Runtime\ActiveRecord\ActiveRecordInterface Athens\Core\Etc\ORMUtils::getObjectById(string $classTableMapName, integer $id)





* Visibility: **protected**
* This method is **static**.


#### Arguments
* $classTableMapName **string**
* $id **integer**



### getTableName

    string Athens\Core\Etc\ORMUtils::getTableName(string $classTableMapName)





* Visibility: **protected**
* This method is **static**.


#### Arguments
* $classTableMapName **string**



### isColumnOf

    boolean Athens\Core\Etc\ORMUtils::isColumnOf(string $classTableMapName, string $columnName)





* Visibility: **protected**
* This method is **static**.


#### Arguments
* $classTableMapName **string**
* $columnName **string**



### getObjectFromURL

    null|\Propel\Runtime\ActiveRecord\ActiveRecordInterface Athens\Core\Etc\ORMUtils::getObjectFromURL(string $classTableMapName)





* Visibility: **public**
* This method is **static**.


#### Arguments
* $classTableMapName **string**



### queryContainsFieldName

    boolean Athens\Core\Etc\ORMUtils::queryContainsFieldName(\Propel\Runtime\ActiveQuery\ModelCriteria $query, string $fieldName)





* Visibility: **public**
* This method is **static**.


#### Arguments
* $query **Propel\Runtime\ActiveQuery\ModelCriteria**
* $fieldName **string**



### getUnqualifiedFieldName

    string Athens\Core\Etc\ORMUtils::getUnqualifiedFieldName(string $qualifiedFieldName)

Retrieve an unqualified field name from a qualified one.



* Visibility: **public**
* This method is **static**.


#### Arguments
* $qualifiedFieldName **string**



### applyFilterToQuery

    \Propel\Runtime\ActiveQuery\ModelCriteria Athens\Core\Etc\ORMUtils::applyFilterToQuery(\Propel\Runtime\ActiveQuery\ModelCriteria $query, string $fieldName, string $criterion, string $criteria)

Adds a filter condition to a given query.

Adaptively uses Propel's ::useXXXQuery() method for related tables.

* Visibility: **public**
* This method is **static**.


#### Arguments
* $query **Propel\Runtime\ActiveQuery\ModelCriteria**
* $fieldName **string**
* $criterion **string**
* $criteria **string**


