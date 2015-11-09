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

        $fieldName = "LiteralField";

        $row = RowBuilder::begin()
            ->addFields([$fieldName => new Field('literal', 'A literal field', [])])
            ->setOnClick("console.log('Click!');")
            ->setHighlightable(true)
            ->build();

        $this->assertEquals("console.log('Click!');", $row->getOnClick());
        $this->assertEquals([$fieldName], $row->getFieldBearer()->getFieldNames());
        $this->assertTrue($row->isHighlightable());
    }

    /*
     * The below methods are tested sufficiently above
    public function testGetFieldBearer() {

    }

    public function testGetOnClick() {

    }
    */


}

