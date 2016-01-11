<?php

namespace UWDOEM\Framework\Test;

use PHPUnit_Framework_TestCase;

use UWDOEM\Framework\Filter\DummyFilter;
use UWDOEM\Framework\Filter\FilterBuilder;
use UWDOEM\Framework\Table\TableBuilder;
use UWDOEM\Framework\FieldBearer\FieldBearerBuilder;
use UWDOEM\Framework\Field\Field;
use UWDOEM\Framework\Row\RowBuilder;
use UWDOEM\Framework\Filter\Filter;
use UWDOEM\Framework\FilterStatement\FilterStatement;

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
            ->addFields([new Field('literal', 'A literal field', [])])
            ->setOnClick("console.log('Click!');")
            ->build();

        $rows = [$row];
        $filter = new DummyFilter();
        $id = "t" . (string)rand();
        $classes = [(string)rand(), (string)rand()];

        $table = TableBuilder::begin()
            ->setId($id)
            ->setRows($rows)
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
     * Get rows should invoke row filtering.
     */
    public function testGetRows()
    {
        $fieldValues = [1, 3];
        $fieldName = "field" . (string)rand();

        $rows = [];

        // Make one row for each of the field values
        foreach ($fieldValues as $fieldValue) {
            $rows[] = RowBuilder::begin()
                ->addFields([$fieldName => new Field('literal', 'A literal field', $fieldValue)])
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
            ->setRows($rows)
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
