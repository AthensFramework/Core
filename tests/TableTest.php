<?php

namespace TestVars;

use UWDOEM\Framework\Filter\DummyFilter;
use UWDOEM\Framework\Table\TableBuilder;
use UWDOEM\Framework\FieldBearer\FieldBearerBuilder;
use UWDOEM\Framework\Field\Field;
use UWDOEM\Framework\Row\RowBuilder;


use PHPUnit_Framework_TestCase;

class TableTest extends PHPUnit_Framework_TestCase
{

    /**
     * @return TableBuilder[]
     */
    public function testedTableBuilders() {
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
    public function testBuilder() {

        $fieldBearer = FieldBearerBuilder::begin()
            ->addFields([new Field('literal', 'A literal field', [])])
            ->build();

        $row = RowBuilder::begin()
            ->setFieldBearer($fieldBearer)
            ->setOnClick("console.log('Click!');")
            ->build();

        $rows = [$row];
        $filter = new DummyFilter();

        $table = TableBuilder::begin()
            ->setRows($rows)
            ->addFilter($filter)
            ->build();

        $this->assertEquals($rows, $table->getRows());
        $this->assertEquals($filter, $table->getFilter());
    }

    /*
     * The below methods are tested sufficiently above
    public function testGetRows() {

    }

    public function testGetFilter() {

    }
    */


}

