<?php


use UWDOEM\Framework\Row\RowBuilder;
use UWDOEM\Framework\FieldBearer\FieldBearerBuilder;
use UWDOEM\Framework\Field\Field;


class RowTest extends PHPUnit_Framework_TestCase
{

    /**
     * @return RowBuilder[]
     */
    public function testedRowBuilders() {
        // Return a fieldBearerBuilder of every type you want to test
        return [
            RowBuilder::begin(),
        ];
    }

    /**
     * Basic tests for the Row builder classes.
     *
     * Any test here could potentially fail because of a failure in the constructed row.
     *
     * @throws \Exception
     */
    public function testBuilder() {

        $fieldBearer = FieldBearerBuilder::begin()
            ->addFields([new Field('literal', 'A literal field')])
            ->build();

        $row = RowBuilder::begin()
            ->setFieldBearer($fieldBearer)
            ->setOnClick("console.log('Click!');")
            ->build();

        $this->assertEquals("console.log('Click!');", $row->getOnClick());
        $this->assertEquals($fieldBearer, $row->getFieldBearer());
    }

    /*
     * The below methods are tested sufficiently above
    public function testGetFieldBearer() {

    }

    public function testGetOnClick() {

    }
    */


}

