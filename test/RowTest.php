<?php

namespace UWDOEM\Framework\Test;

use PHPUnit_Framework_TestCase;

use UWDOEM\Framework\Row\RowBuilder;
use UWDOEM\Framework\FieldBearer\FieldBearerBuilder;
use UWDOEM\Framework\Field\Field;

class RowTest extends PHPUnit_Framework_TestCase
{

    /**
     * @return RowBuilder[]
     */
    public function testedRowBuilders()
    {
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
    public function testBuilder()
    {

        $fieldName = "LiteralField";
        $onClick = "console.log('Click!');";

        $highlightableRow = RowBuilder::begin()
            ->addFields([$fieldName => new Field('literal', 'A literal field', [])])
            ->setHighlightable(true)
            ->build();

        $this->assertEquals([$fieldName], $highlightableRow->getFieldBearer()->getFieldNames());
        $this->assertTrue($highlightableRow->isHighlightable());

        $clickableRow = RowBuilder::begin()
            ->addFields([$fieldName => new Field('literal', 'A literal field', [])])
            ->setOnClick($onClick)
            ->build();

        $this->assertEquals($onClick, $clickableRow->getOnClick());
        $this->assertEquals([$fieldName], $clickableRow->getFieldBearer()->getFieldNames());
        $this->assertFalse($clickableRow->isHighlightable());
    }

    /**
     * @expectedException              Exception
     * @expectedExceptionMessageRegExp #You cannot both make a.*#
     */
    public function testBuilderThrowsExceptionSetContentOnAjaxLoaded()
    {
        $row = RowBuilder::begin()
            ->addFields(["fieldName" => new Field('literal', 'A literal field', [])])
            ->setHighlightable(true)
            ->setOnClick("console.log('Click');")
            ->build();
    }
}
