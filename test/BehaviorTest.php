<?php

namespace Athens\Core\Test;

use PHPUnit_Framework_TestCase;

use Athens\Core\Test\Mock\MockColumn;
use Athens\Core\Test\Mock\MockHTMLFieldBehavior;

class BehaviorTest extends PHPUnit_Framework_TestCase
{
    /** @var array */
    protected $columns;

    public function __construct()
    {
        $this->columns = [
            "Column1" => new MockColumn("Column1", "VARCHAR"),
            "Column2" => new MockColumn("Column2", "VARCHAR"),
            "Column3" => new MockColumn("Column3", "VARCHAR")
        ];

        parent::__construct();
    }

    protected function normalizeWhitespace($string)
    {
        $string = trim($string);
        $string = str_replace("\r", "", $string);

        $string = join("\n", array_map("rtrim", explode("\n", $string)));

        return $string;
    }
    
    public function testAllowMultiple()
    {

        $behavior = new MockHTMLFieldBehavior(
            $this->columns,
            [
                'column_name_1' => "Column1",
                'column_name_2' => "Column2",
            ]
        );
        
        $this->assertFalse($behavior->allowMultiple());
    }

    public function testMapFilter()
    {
        $behavior = new MockHTMLFieldBehavior(
            $this->columns,
            [
                'column_name_1' => "Column1",
                'column_name_2' => "Column2",
            ]
        );

        // Run table map filter once, and an encrypted columns declaration is created
        $behavior->tableMapFilter($this->mapFilterInput);
        $this->assertEquals(
            $this->normalizeWhitespace($this->mapFilterExpected),
            $this->normalizeWhitespace($this->mapFilterInput)
        );
    }

    protected $mapFilterInput = <<<EOT
class ApplicationTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'scholarshipApplication.Map.ApplicationTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'scholarship_application';

EOT;

    protected $mapFilterExpected = <<<'EOT'
class ApplicationTableMap extends TableMap
{
    use InstancePoolTrait;

    /**
     * These columns are HTML fields, per Athens/Core/Behavior/HTMLField
     */
    protected static $htmlFieldColumns = array(
            'table_name.Column1',
            'table_name.Column2'
        );
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'scholarshipApplication.Map.ApplicationTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'scholarship_application';

    /**
     * @param $columnName
     * @return boolean
     */
    public static function isHTMLFieldColumnName($columnName)
    {
        return array_search($columnName, static::$htmlFieldColumns) !== false;
    }
EOT;
}
