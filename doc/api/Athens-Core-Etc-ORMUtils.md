Athens\Core\Etc\ORMUtils
===============

Class ORMUtils provides static methods for interpreting and interfacing
with ORM entities.




* Class name: ORMUtils
* Namespace: Athens\Core\Etc







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


