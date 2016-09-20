<?php

namespace Athens\Core\Test;

use PHPUnit_Framework_TestCase;

use Athens\Core\Filter\DummyFilter;
use Athens\Core\Filter\FilterBuilder;
use Athens\Core\Table\TableBuilder;
use Athens\Core\FieldBearer\FieldBearerBuilder;
use Athens\Core\Field\Field;
use Athens\Core\Row\RowBuilder;
use Athens\Core\Filter\Filter;
use Athens\Core\FilterStatement\FilterStatement;

class TableTest extends PHPUnit_Framework_TestCase
{

    /**
     * @return TableBuilder[]
     */
    public function testedTableBuilders()
    {
        // Return a fieldBearerBuilder of every type you want to test
        return [
            TableBuilder::begin(),
        ];
    }

    /**
     * Basic tests for the Table builder classes.
     *
     * Any test here could potentially fail because of a failure in the constructed table.
     *
     * @throws \Exception
     */
    public function testBuilder()
    {

        $row = RowBuilder::begin()
            ->addWritable(new Field([], [], 'literal', 'A literal field', []))
            ->setOnClick("console.log('Click!');")
            ->build();

        $rows = [$row];
        $filter = new DummyFilter();
        $id = "t" . (string)rand();
        $classes = [(string)rand(), (string)rand()];

        $table = TableBuilder::begin()
            ->setId($id)
            ->addRows($rows)
            ->addClass($classes[0])
            ->addClass($classes[1])
            ->addFilter($filter)
            ->build();

        $this->assertEquals($id, $table->getId());
        $this->assertEquals($classes, $table->getClasses());
        $this->assertEquals($rows, $table->getRows());
        $this->assertEquals($filter, $table->getFilter());
    }

    /**
     * The method ::getRows should invoke row filtering.
     */
    public function testGetRows()
    {
        $fieldValues = [1, 3];
        $fieldName = "field" . (string)rand();

        $rows = [];

        // Make one row for each of the field values
        foreach ($fieldValues as $fieldValue) {
            $rows[] = RowBuilder::begin()
                ->addWritable(new Field([], [], 'literal', 'A literal field', $fieldValue), $fieldName, $fieldName)
                ->build();
        }

        $filter = FilterBuilder::begin()
            ->setId("myFilter")
            ->setType(Filter::TYPE_STATIC)
            ->setFieldName($fieldName)
            ->setCondition(FilterStatement::COND_GREATER_THAN)
            ->setCriterion(2)
            ->build();

        $table = TableBuilder::begin()
            ->setId("t" . (string)rand())
            ->addRows($rows)
            ->addFilter($filter)
            ->build();

        $this->assertEquals(1, sizeof($table->getRows()));
    }

    /*
     * The below methods are tested sufficiently above
    public function testGetFilter() {

    }
    */
}
