<?php

use UWDOEM\Framework\Field\Field;
use UWDOEM\Framework\FieldBearer\FieldBearerBuilder;


class FieldBearerTest extends PHPUnit_Framework_TestCase
{

    /**
     * @return FieldBearerBuilder[]
     */
    public function testedFieldBearerBuilders() {
        // Return a fieldBearerBuilder of every type you want to test
        return [
            FieldBearerBuilder::begin(),
        ];
    }

    /**
     * Basic tests for the FieldBearer builder classes.
     *
     * Any test here could potentially fail because of a failure in the constructed fieldBearer.
     *
     * @throws \Exception
     */
    public function testBuilder() {

        $fields = [
            "fieldName" => new Field("literal", "A literal field"),
            "hiddenFieldName" => new Field("literal", "A hidden literal field")
        ];

        $visibleFieldNames = ["fieldName"];

        $saveFunc = function() { return "saved"; };

        $fieldBearer = FieldBearerBuilder::begin()
            ->setFields($fields)
            ->setVisibleFieldNames($visibleFieldNames)
            ->setSaveFunction($saveFunc)
            ->build();

        $this->assertEquals($fields, $fieldBearer->getFields());
        $this->assertEquals($visibleFieldNames, $fieldBearer->getVisibleFieldNames());
        $this->assertEquals("saved", $fieldBearer->save());

        $fieldBearers = ["fieldBearer" => $fieldBearer];
        $hiddenFieldNames = ["fieldName"];
        $fieldBearer2 = FieldBearerBuilder::begin()
            ->setFieldBearers($fieldBearers)
            ->setHiddenFieldNames($hiddenFieldNames)
            ->build();

        $this->assertEquals($fieldBearers, $fieldBearer2->getFieldBearers());
        $this->assertEquals($hiddenFieldNames, $fieldBearer2->getHiddenFieldNames());

        // Perhaps test that it raises the right errors

        // Perhaps test ClassFieldBearerBuilder
    }

    public function testGetFieldBearers() {

        foreach ($this->testedFieldBearerBuilders() as $builder) {

            $field1 = new Field("literal", "A literal field");
            $field2 = new Field("literal", "Another literal field");
            $field3 = new Field("literal", "Yet another literal field");

            $fieldBearer1 = $builder->setFields(["field1" => $field1])->build();
            $fieldBearer2 = $builder->clear()->setFields(["field2" => $field2, "field3" => $field3])->build();
            $fieldBearer3 = $builder->clear()->setFieldBearers(["fieldBearer2" => $fieldBearer2])->build();

            $fieldBearers = ["fieldBearer1" => $fieldBearer1, "fieldBearer3" => $fieldBearer3];

            $fieldBearer = $builder
                ->setFieldBearers($fieldBearers)
                ->build();

            $this->assertEquals($fieldBearers, $fieldBearer->getFieldBearers());
        }

    }

    public function testGetFieldBearerByName() {
        foreach ($this->testedFieldBearerBuilders() as $builder) {

            $field1 = new Field("literal", "A literal field");
            $field2 = new Field("literal", "Another literal field");
            $field3 = new Field("literal", "Yet another literal field");

            $fieldBearer1 = $builder->setFields(["field1" => $field1])->build();
            $fieldBearer2 = $builder->clear()->setFields(["field2" => $field2, "field3" => $field3])->build();
            $fieldBearer3 = $builder->clear()->setFieldBearers(["fieldBearer2" => $fieldBearer2])->build();

            $fieldBearers = ["fieldBearer1" => $fieldBearer1, "fieldBearer3" => $fieldBearer3];

            $fieldBearer = $builder
                ->setFieldBearers($fieldBearers)
                ->build();

            $this->assertEquals($fieldBearer1, $fieldBearer->getFieldBearerByName("fieldBearer1"));
            $this->assertEquals($fieldBearer3, $fieldBearer->getFieldBearerByName("fieldBearer3"));

            // Sanity check
            $this->assertNotEquals($fieldBearer1, $fieldBearer->getFieldBearerByName("fieldBearer3"));
        }
    }

    public function testGetFieldByName() {

        foreach ($this->testedFieldBearerBuilders() as $builder) {

            $field1 = new Field("literal", "A literal field");
            $field2 = new Field("literal", "Another literal field");
            $field3 = new Field("literal", "Yet another literal field");

            $fieldBearer1 = $builder->setFields(["field1" => $field1])->build();
            $fieldBearer2 = $builder->clear()->setFields(["field2" => $field2, "field3" => $field3])->build();
            $fieldBearer3 = $builder->clear()->setFieldBearers(["fieldBearer2" => $fieldBearer2])->build();

            $fieldBearers = ["fieldBearer1" => $fieldBearer1, "fieldBearer3" => $fieldBearer3];

            $fieldBearer = $builder
                ->setFieldBearers($fieldBearers)
                ->build();

            $this->assertEquals($field1, $fieldBearer->getFieldByName("field1"));
            $this->assertEquals($field2, $fieldBearer->getFieldByName("field2"));
            $this->assertEquals($field3, $fieldBearer->getFieldByName("field3"));

            // Sanity check
            $this->assertNotEquals($field1, $fieldBearer->getFieldByName("field3"));
        }

    }

    public function testGetNameByField() {

        foreach ($this->testedFieldBearerBuilders() as $builder) {

            $field1 = new Field("literal", "A literal field");
            $field2 = new Field("literal", "Another literal field");
            $field3 = new Field("literal", "Yet another literal field");

            $fieldBearer1 = $builder->setFields(["field1" => $field1])->build();
            $fieldBearer2 = $builder->clear()->setFields(["field2" => $field2, "field3" => $field3])->build();
            $fieldBearer3 = $builder->clear()->setFieldBearers(["fieldBearer2" => $fieldBearer2])->build();

            $fieldBearers = ["fieldBearer1" => $fieldBearer1, "fieldBearer3" => $fieldBearer3];

            $fieldBearer = $builder
                ->setFieldBearers($fieldBearers)
                ->build();

            $this->assertEquals("field1", $fieldBearer->getNameByField($field1));
            $this->assertEquals("field2", $fieldBearer->getNameByField($field2));
            $this->assertEquals("field3", $fieldBearer->getNameByField($field3));

            // Sanity check
            $this->assertNotEquals("field1", $fieldBearer->getNameByField($field3));
        }
    }
    
    /**
     * Test getting fields, names, labels for all, visible, and hidden fields
     * @throws \Exception
     */
    public function testFieldsNamesLabelsVisibleFields() {

        // All fields visible
        foreach ($this->testedFieldBearerBuilders() as $builder) {

            $field1 = new Field("literal", "A literal field");
            $field2 = new Field("literal", "Another literal field");
            $field3 = new Field("literal", "Yet another literal field");

            $fieldBearer1 = $builder->setFields(["field1" => $field1])->build();
            $fieldBearer2 = $builder->clear()->setFields(["field2" => $field2, "field3" => $field3])->build();
            $fieldBearer3 = $builder->clear()->setFieldBearers(["fieldBearer2" => $fieldBearer2])->build();

            $fieldBearers = ["fieldBearer1" => $fieldBearer1, "fieldBearer3" => $fieldBearer3];

            $fieldBearer = $builder
                ->setFieldBearers($fieldBearers)
                ->build();

            // All fields
            $fields = $fieldBearer->getFields();
            $fieldNames = $fieldBearer->getFieldNames();
            $fieldLabels = $fieldBearer->getFieldLabels();
            
            $this->assertTrue(in_array($field1, $fields) && in_array($field2, $fields) && in_array($field3, $fields));
            $this->assertEquals(3, sizeof($fields));
            
            $this->assertTrue(in_array("field1", $fieldNames) && in_array("field2", $fieldNames) && in_array("field3", $fieldNames));
            $this->assertEquals(3, sizeof($fieldNames));
            
            $this->assertTrue(in_array("A literal field", $fieldLabels) && in_array("Another literal field", $fieldLabels) && in_array("Yet another literal field", $fieldLabels));
            $this->assertEquals(3, sizeof($fieldLabels));
            
            
            // Visible fields
            $this->assertEquals($fieldBearer->getFields(), $fieldBearer->getVisibleFields());
            $this->assertEquals($fieldBearer->getFieldNames(), $fieldBearer->getVisibleFieldNames());
            $this->assertEquals($fieldBearer->getLabels(), $fieldBearer->getVisibleLabels());

            // Hidden fields
            $this->assertEmpty($fieldBearer->getHiddenFields());
            $this->assertEmpty($fieldBearer->getHiddenFieldNames());
            $this->assertEmpty($fieldBearer->getHiddenLabels());
        }

        // Specific fields visible, specific fields hidden
        foreach ($this->testedFieldBearerBuilders() as $builder) {

            $field1 = new Field("literal", "A literal field");
            $field2 = new Field("literal", "Another literal field");
            $field3 = new Field("literal", "Yet another literal field");

            $fieldBearer1 = $builder->clear()->setFields(["field1" => $field1])->build();
            $fieldBearer2 = $builder->clear()->setFields(["field2" => $field2, "field3" => $field3])->build();
            $fieldBearer3 = $builder
                ->clear()
                ->setFieldBearers([$fieldBearer2])
                ->setVisibleFieldNames(["field1"])
                ->setHiddenFieldNames(["field3"])
                ->build();

            $fieldBearers = ["fieldBearer1" => $fieldBearer1, "fieldBearer3" => $fieldBearer3];

            $fieldBearer = $builder
                ->setFieldBearers($fieldBearers)
                ->build();

            // All fields
            $fields = $fieldBearer->getFields();
            $fieldNames = $fieldBearer->getFieldNames();
            $fieldLabels = $fieldBearer->getFieldLabels();

            $this->assertTrue(in_array($field1, $fields) && in_array($field2, $fields) && in_array($field3, $fields));
            $this->assertEquals(3, sizeof($fields));

            $this->assertTrue(in_array("field1", $fieldNames) && in_array("field2", $fieldNames) && in_array("field3", $fieldNames));
            $this->assertEquals(3, sizeof($fieldNames));

            $this->assertTrue(in_array("A literal field", $fieldLabels) && in_array("Another literal field", $fieldLabels) && in_array("Yet another literal field", $fieldLabels));
            $this->assertEquals(3, sizeof($fieldLabels));


            // Visible fields
            $fields = $fieldBearer->getVisibleFields();
            $fieldNames = $fieldBearer->getVisibleFieldNames();
            $fieldLabels = $fieldBearer->getVisibleLabels();

            $this->assertTrue(in_array($field1, $fields));
            $this->assertEquals(1, sizeof($fields));

            $this->assertTrue(in_array("field1", $fieldNames));
            $this->assertEquals(1, sizeof($fieldNames));

            $this->assertTrue(in_array("A literal field", $fieldLabels));
            $this->assertEquals(1, sizeof($fieldLabels));

            // Hidden fields
            $fields = $fieldBearer->getHiddenFields();
            $fieldNames = $fieldBearer->getHiddenFieldNames();
            $fieldLabels = $fieldBearer->getHiddenLabels();

            $this->assertTrue(in_array($field3, $fields));
            $this->assertEquals(1, sizeof($fields));

            $this->assertTrue(in_array("field3", $fieldNames));
            $this->assertEquals(1, sizeof($fieldNames));

            $this->assertTrue(in_array("Yet another literal field", $fieldLabels));
            $this->assertEquals(1, sizeof($fieldLabels));
        }
    }
}

