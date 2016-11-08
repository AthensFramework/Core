<?php

namespace Athens\Core\Test;

use PHPUnit_Framework_TestCase;

use Athens\Core\Row\RowBuilder;
use Athens\Core\Field\FieldBuilder;
use Athens\Core\Field\Field;

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
            ->addWritable(new Field([], [], 'literal', 'A literal field', []), $fieldName)
            ->setHighlightable(true)
            ->build();

        $this->assertEquals([$fieldName], array_keys($highlightableRow->getWritableBearer()->getWritables()));
        $this->assertTrue($highlightableRow->isHighlightable());

        $clickableRow = RowBuilder::begin()
            ->addWritable(new Field([], [], 'literal', 'A literal field', []), $fieldName)
            ->setOnClick($onClick)
            ->build();

        $this->assertEquals($onClick, $clickableRow->getOnClick());
        $this->assertEquals([$fieldName], array_keys($clickableRow->getWritableBearer()->getWritables()));
        $this->assertFalse($clickableRow->isHighlightable());
    }

    public function testIntersectWritableNames()
    {
        $fieldName1 = "fieldname1";
        $field1 = FieldBuilder::begin()->setType(Field::TYPE_LITERAL)->setLabel('field1')->build();
        $fieldName2 = "fieldname2";
        $field2 = FieldBuilder::begin()->setType(Field::TYPE_LITERAL)->setLabel('field1')->build();
        $fieldName3 = "fieldname3";
        $field3 = FieldBuilder::begin()->setType(Field::TYPE_LITERAL)->setLabel('field1')->build();

        $row = RowBuilder::begin()
            ->addWritable($field1, $fieldName1)
            ->addWritable($field2, $fieldName2)
            ->addWritable($field3, $fieldName3)
            ->intersectWritableNames([$fieldName1, $fieldName3])
            ->build();

        $this->assertEquals([$fieldName1 => $field1, $fieldName3 => $field3], $row->getWritables());
        $this->assertEquals([$fieldName1 => $fieldName1, $fieldName3 => $fieldName3], $row->getLabels());
    }

    public function testAddContent()
    {
        $literalContent = "Literal\nContent";
        $content = "Just\nContent";

        $literalContentLabel = "Literal Content";
        $contentLabel = "Just Content";

        $row = RowBuilder::begin()
            ->addContent($content, $contentLabel, $contentLabel)
            ->addLiteralContent($literalContent, $literalContentLabel, $literalContentLabel)
            ->build();

        $writables = array_combine($row->getLabels(), $row->getWritables());


        $this->assertEquals(
            $literalContent,
            $writables[$literalContentLabel]->getInitial()
        );

        $this->assertEquals(
            nl2br($content),
            $writables[$contentLabel]->getInitial()
        );
    }

    /**
     * @expectedException              Exception
     * @expectedExceptionMessageRegExp #You cannot both make a.*#
     */
    public function testBuilderThrowsExceptionSetContentOnAjaxLoaded()
    {
        $row = RowBuilder::begin()
            ->addWritable(new Field([], [], 'literal', 'A literal field', []), "fieldName")
            ->setHighlightable(true)
            ->setOnClick("console.log('Click');")
            ->build();
        
        RowBuilder::begin()->addLabel('bla');
    }
}
