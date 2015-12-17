<?php

namespace UWDOEM\Framework\Test;

use PHPUnit_Framework_TestCase;

use UWDOEM\Framework\Field\Field;
use UWDOEM\Framework\FieldBearer\FieldBearerBuilder;
use UWDOEM\Framework\Etc\ORMUtils;
use UWDOEMTest\TestClass;

use UWDOEM\Framework\Test\Mock\MockTestClass;

class FieldBearerTest extends PHPUnit_Framework_TestCase
{

    /**
     * @return FieldBearerBuilder[]
     */
    public function testedFieldBearerBuilders()
    {
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
    public function testBuilder()
    {

        $fields = [
            "fieldName" => new Field("literal", "A literal field", []),
            "hiddenFieldName" => new Field("literal", "A hidden literal field", [])
        ];

        $visibleFieldNames = ["fieldName"];

        $saveFunc = function () {
            return "saved";

        };

        $fieldBearer = FieldBearerBuilder::begin()
            ->addFields($fields)
            ->setVisibleFieldNames($visibleFieldNames)
            ->setSaveFunction($saveFunc)
            ->build();

        $this->assertEquals($fields, $fieldBearer->getFields());
        $this->assertEquals($visibleFieldNames, $fieldBearer->getVisibleFieldNames());
        $this->assertEquals("saved", $fieldBearer->save());

        $fieldBearers = ["fieldBearer" => $fieldBearer];
        $hiddenFieldNames = ["fieldName"];
        $fieldBearer2 = FieldBearerBuilder::begin()
            ->addFieldBearers($fieldBearers)
            ->setHiddenFieldNames($hiddenFieldNames)
            ->build();

        $this->assertEquals($fieldBearers, $fieldBearer2->getFieldBearers());
        $this->assertEquals($hiddenFieldNames, $fieldBearer2->getHiddenFieldNames());

        // Perhaps test that it raises the right errors

        // Test FieldBearerBuilder with ClassFieldBearer using addObject
        $object = new TestClass();
        $classFieldBearer = FieldBearerBuilder::begin()
            ->addObject($object)
            ->build();

        $expectedFieldNames = array_keys(ORMUtils::makeFieldsFromObject($object));
        $this->assertEquals($expectedFieldNames, $classFieldBearer->getFieldNames());

        // Test FieldBearerBuilder with ClassFieldBearer using addClassTableMapName
        $object = new TestClass();
        $classFieldBearer = FieldBearerBuilder::begin()
            ->addClassTableMapName($object::TABLE_MAP)
            ->build();

        $expectedFieldNames = array_keys(ORMUtils::makeFieldsFromObject($object));
        $this->assertEquals($expectedFieldNames, $classFieldBearer->getFieldNames());
    }

    public function testSetInitialWithFieldBearerBuilder()
    {
        $field1 = new Field("literal", "", []);
        $field2 = new Field("literal", "", []);

        $fields = [
            "field1" => $field1,
            "field2" => $field2
        ];

        $newInitialValue = (string)rand();

        FieldBearerBuilder::begin()
            ->addFields($fields)
            ->setInitialFieldValue("field1", $newInitialValue)
            ->build();

        $this->assertEquals($newInitialValue, $field1->getInitial());
        $this->assertNotEquals($newInitialValue, $field2->getInitial());
    }

    public function testGetFieldBearers()
    {

        foreach ($this->testedFieldBearerBuilders() as $builder) {

            $field1 = new Field("literal", "A literal field", []);
            $field2 = new Field("literal", "Another literal field", []);
            $field3 = new Field("literal", "Yet another literal field", []);

            $fieldBearer1 = $builder->addFields(["field1" => $field1])->build();
            $fieldBearer2 = $builder->clear()->addFields(["field2" => $field2, "field3" => $field3])->build();
            $fieldBearer3 = $builder->clear()->addFieldBearers(["fieldBearer2" => $fieldBearer2])->build();

            $fieldBearers = ["fieldBearer1" => $fieldBearer1, "fieldBearer3" => $fieldBearer3];

            $fieldBearer = $builder
                ->clear()
                ->addFieldBearers($fieldBearers)
                ->build();

            $this->assertEquals($fieldBearers, $fieldBearer->getFieldBearers());
        }

    }

    public function testGetFieldBearerByName()
    {
        foreach ($this->testedFieldBearerBuilders() as $builder) {

            $field1 = new Field("literal", "A literal field", []);
            $field2 = new Field("literal", "Another literal field", []);
            $field3 = new Field("literal", "Yet another literal field", []);

            $fieldBearer1 = $builder->addFields(["field1" => $field1])->build();
            $fieldBearer2 = $builder->clear()->addFields(["field2" => $field2, "field3" => $field3])->build();
            $fieldBearer3 = $builder->clear()->addFieldBearers(["fieldBearer2" => $fieldBearer2])->build();

            $fieldBearers = ["fieldBearer1" => $fieldBearer1, "fieldBearer3" => $fieldBearer3];

            $fieldBearer = $builder
                ->addFieldBearers($fieldBearers)
                ->build();

            $this->assertEquals($fieldBearer1, $fieldBearer->getFieldBearerByName("fieldBearer1"));
            $this->assertEquals($fieldBearer3, $fieldBearer->getFieldBearerByName("fieldBearer3"));

            // Sanity check
            $this->assertNotEquals($fieldBearer1, $fieldBearer->getFieldBearerByName("fieldBearer3"));
        }
    }

    public function testGetFieldByName()
    {

        foreach ($this->testedFieldBearerBuilders() as $builder) {

            $field1 = new Field("literal", "A literal field", []);
            $field2 = new Field("literal", "Another literal field", []);
            $field3 = new Field("literal", "Yet another literal field", []);

            $fieldBearer1 = $builder->addFields(["field1" => $field1])->build();
            $fieldBearer2 = $builder->clear()->addFields(["field2" => $field2, "field3" => $field3])->build();
            $fieldBearer3 = $builder->clear()->addFieldBearers(["fieldBearer2" => $fieldBearer2])->build();

            $fieldBearers = ["fieldBearer1" => $fieldBearer1, "fieldBearer3" => $fieldBearer3];

            $fieldBearer = $builder
                ->addFieldBearers($fieldBearers)
                ->build();

            $this->assertEquals($field1, $fieldBearer->getFieldByName("field1"));
            $this->assertEquals($field2, $fieldBearer->getFieldByName("field2"));
            $this->assertEquals($field3, $fieldBearer->getFieldByName("field3"));

            // Sanity check
            $this->assertNotEquals($field1, $fieldBearer->getFieldByName("field3"));
        }

    }

    public function testGetNameByField()
    {

        foreach ($this->testedFieldBearerBuilders() as $builder) {

            $field1 = new Field("literal", "A literal field", []);
            $field2 = new Field("literal", "Another literal field", []);
            $field3 = new Field("literal", "Yet another literal field", []);

            $fieldBearer1 = $builder->addFields(["field1" => $field1])->build();
            $fieldBearer2 = $builder->clear()->addFields(["field2" => $field2, "field3" => $field3])->build();
            $fieldBearer3 = $builder->clear()->addFieldBearers(["fieldBearer2" => $fieldBearer2])->build();

            $fieldBearers = ["fieldBearer1" => $fieldBearer1, "fieldBearer3" => $fieldBearer3];

            $fieldBearer = $builder
                ->addFieldBearers($fieldBearers)
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
    public function testFieldsNamesLabelsVisibleFields()
    {

        // All fields visible
        foreach ($this->testedFieldBearerBuilders() as $builder) {

            $field1 = new Field("literal", "A literal field", []);
            $field2 = new Field("literal", "Another literal field", []);
            $field3 = new Field("literal", "Yet another literal field", []);

            $fieldBearer1 = $builder->clear()->addFields(["field1" => $field1])->build();
            $fieldBearer2 = $builder->clear()->addFields(["field2" => $field2, "field3" => $field3])->build();
            $fieldBearer3 = $builder->clear()->addFieldBearers(["fieldBearer2" => $fieldBearer2])->build();

            $fieldBearers = ["fieldBearer1" => $fieldBearer1, "fieldBearer3" => $fieldBearer3];

            $fieldBearer = $builder
                ->clear()
                ->addFieldBearers($fieldBearers)
                ->build();

            // All fields
            $fields = $fieldBearer->getFields();
            $fieldNames = $fieldBearer->getFieldNames();
            $fieldLabels = $fieldBearer->getFieldLabels();

            $this->assertContains($field1, $fields);
            $this->assertContains($field2, $fields);
            $this->assertContains($field3, $fields);
            $this->assertEquals(3, sizeof($fields));

            $this->assertContains("field1", $fieldNames);
            $this->assertContains("field2", $fieldNames);
            $this->assertContains("field3", $fieldNames);
            $this->assertEquals(3, sizeof($fieldNames));

            $this->assertContains("A literal field", $fieldLabels);
            $this->assertContains("Another literal field", $fieldLabels);
            $this->assertContains("Yet another literal field", $fieldLabels);
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

            $field1 = new Field("literal", "A literal field", []);
            $field2 = new Field("literal", "Another literal field", []);
            $field3 = new Field("literal", "Yet another literal field", []);

            $fieldBearer1 = $builder->clear()->addFields(["field1" => $field1])->build();
            $fieldBearer2 = $builder->clear()->addFields(["field2" => $field2, "field3" => $field3])->build();
            $fieldBearer3 = $builder
                ->clear()
                ->addFieldBearers([$fieldBearer2])
                ->setVisibleFieldNames(["field2"])
                ->setHiddenFieldNames(["field3"])
                ->build();

            $fieldBearers = ["fieldBearer1" => $fieldBearer1, "fieldBearer3" => $fieldBearer3];

            $fieldBearer = $builder
                ->clear()
                ->addFieldBearers($fieldBearers)
                ->build();
            // All fields
            $fields = $fieldBearer->getFields();
            $fieldNames = $fieldBearer->getFieldNames();
            $fieldLabels = $fieldBearer->getFieldLabels();

            $this->assertContains($field1, $fields);
            $this->assertContains($field2, $fields);
            $this->assertContains($field3, $fields);
            $this->assertEquals(3, sizeof($fields));

            $this->assertContains("field1", $fieldNames);
            $this->assertContains("field2", $fieldNames);
            $this->assertContains("field3", $fieldNames);
            $this->assertEquals(3, sizeof($fieldNames));

            $this->assertContains("A literal field", $fieldLabels);
            $this->assertContains("Another literal field", $fieldLabels);
            $this->assertContains("Yet another literal field", $fieldLabels);
            $this->assertEquals(3, sizeof($fieldLabels));


            // Visible fields
            $fields = $fieldBearer->getVisibleFields();
            $fieldNames = $fieldBearer->getVisibleFieldNames();
            $fieldLabels = $fieldBearer->getVisibleLabels();

            $this->assertTrue(in_array($field1, $fields));
            $this->assertEquals(2, sizeof($fields));

            $this->assertTrue(in_array("field1", $fieldNames));
            $this->assertTrue(in_array("field2", $fieldNames));
            $this->assertEquals(2, sizeof($fieldNames));

            $this->assertTrue(in_array("A literal field", $fieldLabels));
            $this->assertEquals(2, sizeof($fieldLabels));

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

    public function testClassFieldBuilderSavesObject()
    {
        $object = new MockTestClass();

        $fieldBearer = FieldBearerBuilder::begin()
            ->addObject($object)
            ->build();

        $fieldBearer->save();

        $this->assertTrue($object->saved);
    }

    public function testClassFieldBuilderUpdatesObject()
    {
        $object = new MockTestClass();

        $fieldBearer = FieldBearerBuilder::begin()
            ->addObject($object)
            ->build();

        $field = $fieldBearer->getFieldByName("TestClass.FieldLargeVarchar");

        $data = (string)rand();
        $_POST[$field->getSlug()] = $data;

        // Assert that the object does not yet contain the assigned data
        $this->assertNotEquals($data, $object->getFieldLargeVarchar());

        // Validate the data, and check to make sure that the posted data validated
        $field->validate();
        $this->assertEquals($data, $field->getValidatedData());

        // Save the field bearer, which will save the object, and assert that the object
        // does contain the assigned data
        $fieldBearer->save();
        $this->assertEquals($data, $object->getFieldLargeVarchar());
    }
}
