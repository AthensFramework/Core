<?php

namespace Athens\Core\Behavior;

use Propel\Generator\Model\Behavior;

/**
 * Class HTMLField
 * @package Athens\Core\Behavior
 */
class HTMLField extends Behavior
{

    /**
     * Multiple encrypted columns in the same table is OK.
     *
     * @return boolean
     */
    public function allowMultiple()
    {
        return false;
    }

    /**
     * @param string $script
     * @return void
     */
    public function tableMapFilter(&$script)
    {
        $fieldName = '$htmlFieldColumns';
        $columnNames = [];
        foreach ($this->getColumnRealNames() as $columnName) {
            $columnNames[] = "'$columnName'";
        }
        $columnNames = implode(",\n            ", $columnNames);

        $content = <<<EOT


    /**
     * These columns are HTML fields, per Athens/Core/Behavior/HTMLField
     */
    protected static $fieldName = array(
            $columnNames
        );
EOT;
        $insertLocation = strpos($script, ";", strpos($script, "const TABLE_NAME")) + 1;
        $script = substr_replace($script, $content, $insertLocation, 0);

        $useString = <<<'EOT'


    /**
     * @param $columnName
     * @return boolean
     */
    public static function isHTMLFieldColumnName($columnName)
    {
        return array_search($columnName, static::$htmlFieldColumns) !== false;
    }
EOT;

        $script = substr_replace(
            $script,
            $useString,
            strrpos($script, '}') - 1,
            0
        );
    }

    /**
     * @return string[]
     */
    protected function getColumnNames()
    {
        $columnNames = [];
        foreach ($this->getParameters() as $key => $columnName) {
            if (strpos($key, "column_name") !== false && empty($columnName) !== true) {
                $columnNames[] = $columnName;
            }
        }
        return $columnNames;
    }

    /**
     * @return string[]
     */
    protected function getColumnRealNames()
    {
        $tableName = $this->getTable()->getName();

        return array_map(
            function ($columnName) use ($tableName) {
                return "$tableName.$columnName";
            },
            $this->getColumnNames()
        );
    }
}
