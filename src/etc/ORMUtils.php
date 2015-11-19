<?php

namespace UWDOEM\Framework\Etc;

use Propel\Runtime\Map\Exception\ColumnNotFoundException;

use UWDOEM\Framework\Field\Field;


/**
 * Class ORMUtils provides static methods for interpreting and interfacing
 * with ORM entities.
 *
 * @package UWDOEM\Framework\Etc
 */
class ORMUtils {

    static protected $db_type_to_field_type_association = [
        "VARCHAR"=> "text",
        "INTEGER"=> "text",
        "VARBINARY"=> "text",
        "TIMESTAMP"=> "datetime",
        "BOOLEAN"=> "boolean",
        "FLOAT"=> "text",
    ];

    /**
     * @param \Propel\Runtime\ActiveRecord\ActiveRecordInterface $object
     * @return Field[]
     */
    static public function makeFieldsFromObject($object) {
        $fieldNames = static::makeFieldNamesFromObject($object);

        $columns = array_combine($fieldNames, static::getColumns($object::TABLE_MAP));
        $fields = array_combine($fieldNames, static::makeFieldsFromColumns($columns));

        $fields = static::addBehaviorConstraintsToFields($object::TABLE_MAP, $fields, $columns);

        foreach($columns as $fieldName=>$column) {
            $phpName = $column->getPhpName();
            $initial = $object->{"get" . $phpName}();

            $fields[$fieldName]->setInitial($initial);
        }

        return $fields;
    }

    /**
     * @param $tableMapName
     * @param \UWDOEM\Framework\Field\FieldInterface[] $fields
     * @param $columns
     * @return mixed
     */
    static public function addBehaviorConstraintsToFields($tableMapName, $fields, $columns) {

        $behaviors = static::getClassTableMap($tableMapName)->getBehaviors();
        $validateBehaviors = array_key_exists("validate", $behaviors) ? $behaviors["validate"] : [];

        $validateBehaviorsByColumn = [];
        foreach ($validateBehaviors as $behavior) {
            $columnName = $behavior["column"];
            if (!array_key_exists($columnName, $validateBehaviorsByColumn)) {
                $validateBehaviorsByColumn[$columnName] = [];
            }

            $validateBehaviorsByColumn[$columnName][] = $behavior;
        }

        foreach($columns as $fieldName=>$column) {
            $columnName = $column->getName();

            if (array_key_exists($columnName, $validateBehaviorsByColumn)) {
                foreach ($validateBehaviorsByColumn[$columnName] as $behavior) {
                    if($behavior["validator"] === "Choice") {
                        $fields[$fieldName]->setType("choice");
                        $fields[$fieldName]->setChoices($behavior["options"]["choices"]);
                    }
                }
            }
        }

        return $fields;

    }

    /**
     * @param string $classTableMapName
     * @return \Propel\Runtime\ActiveRecord\ActiveRecordInterface
     */
    static public function makeNewObjectFromClassTableMapName($classTableMapName) {
        $className = static::getObjectClass($classTableMapName);
        return new $className;
    }

    /**
     * @param string $fieldName
     * @param string $classTableMapName
     * @return bool
     */
    static public function isEncrypted($fieldName, $classTableMapName) {
        if (defined($classTableMapName . "::ENCRYPTED_COLUMNS")) {

            $encryptedFieldNames = explode(" ", $classTableMapName::ENCRYPTED_COLUMNS);
            $phpName = explode(".", $fieldName)[1];

            return array_search($phpName, $encryptedFieldNames) !== false;
        }

        return false;
    }

    static public function fillObjectFromFields($object, $fields) {
        $fieldNames = array_keys($fields);
        $columns = ORMUtils::getColumns($object::TABLE_MAP);

        $columns = array_combine($fieldNames, $columns);

        foreach ($columns as $fieldName => $column) {
            $field = $fields[$fieldName];

            if ($column->isPrimaryKey()) {
                // Don't accept form input for primary keys. These should be set at object creation.
            } elseif ($column->getPhpName() === "UpdatedAt" || $column->getPhpName() === "CreatedAt") {
                // Don't accept updates to the UpdatedAt or CreatedAt timestamps
            } else {
                $object->{"set" . $column->getPhpName()}($field->getValidatedData());
                $field->setInitial($field->getValidatedData());
            }

        }
    }

    /**
     * @param \Propel\Runtime\ActiveRecord\ActiveRecordInterface $object
     * @return string[]
     */
    static protected function makeFieldNamesFromObject($object) {
        $objectName = static::getPhpNameFromObject($object);
        $columns = static::getColumns($object::TABLE_MAP);

        return array_values(array_map(function($column) use ($objectName) {
            return $objectName . "." . $column->getPhpName();
        }, $columns));
    }

    /**
     * @param string $classTableMapName
     * @return \Propel\Runtime\Map\TableMap
     */
    static protected function getClassTableMap($classTableMapName) {
        return $classTableMapName::getTableMap();
    }

    /**
     * Return a Propel TableMap corresponding to a table within the same schema as $fullyQualifiedTableMapName.
     *
     * In some cases, a foreign table map within the same database as $this may not be initialized by Propel. If
     * we try to access a foregin table map using runtime introspection and it has not yet been initialized, then
     * Propel will throw a TableNotFoundException. This method accesses the table map by access to its fully
     * qualified class name, which it determines by modifying $this->_classTableMapName.
     *
     * @param   string    $tableName  The SQL name of the related table for which you would like to retrieve a table map
     * @param   string    $fullyQualifiedTableMapName  A fully qualified table map name within the schema of
     *
     * @return  \Propel\Runtime\Map\TableMap
     */
    static protected function getRelatedTableMap($tableName, $fullyQualifiedTableMapName) {

        $upperCamelCaseTableName = StringUtils::toUpperCamelCase($tableName) . "TableMap";

        // We build he fully qualified name of the related table map class
        // by doing some complicated search and replace on the fully qualified
        // table map name of the child.
        $fullyQualifiedRelatedTableName = substr_replace(
                $fullyQualifiedTableMapName,
                $upperCamelCaseTableName, strrpos($fullyQualifiedTableMapName, "\\", -1) + 1) . "\n";
        $fullyQualifiedParentTableName = trim($fullyQualifiedRelatedTableName);

        return static::getClassTableMap($fullyQualifiedParentTableName);
    }

    /**
     * @param string $classTableMapName
     * @return \Propel\Runtime\Map\TableMap[]
     */
    static protected function findParentTables($classTableMapName) {
        // Make recursive
        $behaviors = static::getClassTableMap($classTableMapName)->getBehaviors();

        $parentTables = [];
        if (array_key_exists("delegate", $behaviors)) {
            $parentTables[] = static::getRelatedTableMap($behaviors["delegate"]["to"], $classTableMapName);
        }
        return $parentTables;
    }

    /**
     * @param string $classTableMapName
     * @return \Propel\Runtime\Map\ColumnMap[]
     */
    static protected function getColumns($classTableMapName) {
        $columns = [];

        foreach (static::findParentTables($classTableMapName) as $parentTable) {
            $columns = array_merge($columns, $parentTable->getColumns());
        }

        return array_merge($columns, static::getClassTableMap($classTableMapName)->getColumns());
    }

    /**
     * @param \Propel\Runtime\Map\ColumnMap $column
     * @return string
     */
    static protected function chooseFieldType($column) {

        $type = ORMUtils::$db_type_to_field_type_association[$column->getType()];

        if ($type == "text" && $column->getSize() >= 128) {
            $type = "textarea";
        }

        return $type;
    }

    /**
     * @param \Propel\Runtime\Map\ColumnMap[] $columns
     * @return Field[]
     */
    static protected function makeFieldsFromColumns(array $columns) {

        $fields = [];
        $initial = "";
        foreach ($columns as $column) {
            $label = $column->getName();
            $choices = [];

            // The primary key ID field should be presented as a hidden html field
            if ($column->isPrimaryKey()) {
                $fieldType = FIELD::FIELD_TYPE_PRIMARY_KEY;
                $fieldRequired = false;
            } elseif ($column->isForeignKey()) {
                $fieldType = FIELD::FIELD_TYPE_FOREIGN_KEY;
                $fieldRequired = false;
            } elseif ($column->getPhpName() === "UpdatedAt" || $column->getPhpName() === "CreatedAt") {
                $fieldType = FIELD::FIELD_TYPE_AUTO_TIMESTAMP;
                $fieldRequired = false;
            } else {
                $fieldType = self::chooseFieldType($column);
                $fieldRequired = $column->isNotNull();
            }

            $label = StringUtils::toTitleCase($label);

            $fieldSize = $column->getSize();

            $fields[] = new Field($fieldType, $label, $initial, $fieldRequired, $choices, $fieldSize);
        }

        return $fields;
    }

    /**
     * @param string $classTableMapName
     * @return \UWDOEM\Framework\Field\Field[]
     */
    static protected function makeFieldsFromClassTableMapName($classTableMapName) {
        $columns = static::getColumns($classTableMapName);
        return static::makeFieldsFromColumns($columns);
    }

    /**
     * @param $object
     * @return string
     */
    static protected function getPhpNameFromObject($object) {
        $tableMapName = $object::TABLE_MAP;

        /** @var \Propel\Runtime\Map\TableMap $tableMap */
        $tableMap = new $tableMapName();
        return $tableMap->getPhpName();
    }

    /**
     * @param string $classTableMapName
     * @return string
     */
    static protected function getObjectClass($classTableMapName) {
        $search = ["\\Map", "TableMap"];
        $replace = ["", ""];

        return str_replace($search, $replace, $classTableMapName);
    }

    /**
     * Return a Propel ActiveQuery object corresponding to $this->_classTableMapName
     *
     * @return \Propel\Runtime\ActiveQuery\PropelQuery
     */
    static protected function createQuery($classTableMapName) {

        $queryName = str_replace(["TableMap", "\\Map\\"], ["Query", "\\"], $classTableMapName);
        return $queryName::create();
    }

    /**
     * @param string $classTableMapName
     * @param string $fieldPhpName
     * @param mixed $value
     * @param "find"|"findOne" $findType
     * @return \Propel\Runtime\ActiveRecord\ActiveRecordInterface[]|\Propel\Runtime\ActiveRecord\ActiveRecordInterface
     */
    static protected function baseFindAmongInheritance($classTableMapName, $fieldPhpName, $value, $findType) {
        // If the field is native to this class...
        try {
            // Test that the table has the prescribed column. Will fail with a ColumnNotFoundException if it does not.
            $unused = static::getClassTableMap($classTableMapName)->getColumnByPhpName($fieldPhpName);

            return static::createQuery($classTableMapName)->
                        {"filterBy" . $fieldPhpName}($value)->
                        $findType();

            // Else, the field is native to a parent class (we hope!)...
        } catch (ColumnNotFoundException $e) {
            // Make recursive. Include error for when we cannot find the field.

            return static::createQuery($classTableMapName)->
                        {"use" . static::findParentTables($classTableMapName)[0]->getPhpName() . "Query"}()->
                        {"filterBy" . $fieldPhpName}($value)->
                        endUse()->
                        $findType();
        }
    }

    /**
     * @param string $classTableMapName
     * @param string $fieldPhpName
     * @param mixed $value
     * @return \Propel\Runtime\ActiveRecord\ActiveRecordInterface[]
     */
    static protected function findByAmongInheritance($classTableMapName, $fieldPhpName, $value) {
        return static::baseFindAmongInheritance($classTableMapName, $fieldPhpName, $value, "find");
    }

    /**
     * @param string $classTableMapName
     * @param string $fieldPhpName
     * @param mixed $value
     * @return \Propel\Runtime\ActiveRecord\ActiveRecordInterface[]
     */
    static protected function findOneByAmongInheritance($classTableMapName, $fieldPhpName, $value) {
        return static::baseFindAmongInheritance($classTableMapName, $fieldPhpName, $value, "findOne");
    }

    /**
     * @param string $classTableMapName
     * @param int $id
     * @return \Propel\Runtime\ActiveRecord\ActiveRecordInterface
     */
    static protected function getObjectById($classTableMapName, $id) {
        return static::createQuery($classTableMapName)->findPk($id);
    }

    /**
     * @param $classTableMapName
     * @return string
     */
    static protected function getTableName($classTableMapName) {
        $columns = static::getColumns($classTableMapName);
        return array_values($columns)[0]->getTableName();
    }

    /**
     * @param string $classTableMapName
     * @param string $columnName
     * @return bool
     */
    static protected function isColumnOf($classTableMapName, $columnName) {
        $columns = static::getColumns($classTableMapName);
        return array_key_exists($columnName, $columns);
    }

    /**
     * @param string $classTableMapName
     * @return null|\Propel\Runtime\ActiveRecord\ActiveRecordInterface
     */
    static public function getObjectFromURL($classTableMapName) {
        $object = null;

        $urlIdKey = static::getTableName($classTableMapName) . "_id";

        // Test whether the primary key of the object is in the GET vars
        if (array_key_exists($urlIdKey, $_GET)) {
            $object = static::getObjectById($classTableMapName, $_GET[$urlIdKey]);
        } else {
        // Else, test whether a related id is in the GET vars
            foreach ($_GET as $key=>$value) {
                if (static::isColumnOf($classTableMapName, strtoupper($key))) {
                    $fieldPhpName = StringUtils::toUpperCamelCase($key);
                    $object = static::findOneByAmongInheritance($classTableMapName, $fieldPhpName, $value);

                    break;
                }
            }
        }
        return $object;
    }

    static public function queryContainsFieldName($query, $fieldName) {
        /** @var \Propel\Runtime\Map\TableMap $map */
        $map = $query->getTableMap();
        $objectName = $map->getPhpName();

        foreach($map->getColumns() as $column) {
            $thisFieldName = $objectName . "." . StringUtils::toUpperCamelCase($column->getPhpName());

            if ($fieldName == $thisFieldName) {
                return true;
            }
        }

        return false;
    }

}
