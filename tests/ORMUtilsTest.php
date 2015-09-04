<?php

use UWDOEM\Framework\Etc\ORMUtils;
use UWDOEMTest\TestClass;
use UWDOEM\Encryption\Cipher;

Cipher::createInstance("my_secret_passphrase");


class ORMUtilsTest extends PHPUnit_Framework_TestCase
{
    public function testMakeFieldNamesFromObject() {
        $o = new TestClass();

        $fields = ORMUtils::makeFieldsFromObject($o);
        $fieldNames = array_keys($fields);

        $this->assertContains("TestClass.Id", $fieldNames);
        $this->assertContains("TestClass.FieldSmallVarchar", $fieldNames);
        $this->assertContains("TestClass.FieldLargeVarchar", $fieldNames);
        $this->assertContains("TestClass.FieldInteger", $fieldNames);
        $this->assertContains("TestClass.FieldFloat", $fieldNames);
        $this->assertContains("TestClass.FieldTimestamp", $fieldNames);
        $this->assertContains("TestClass.FieldBoolean", $fieldNames);
        $this->assertContains("TestClass.RequiredField", $fieldNames);
        $this->assertContains("TestClass.UnrequiredField", $fieldNames);
        $this->assertContains("TestClass.EncryptedField", $fieldNames);

        $this->assertEquals(10, sizeof($fieldNames));
    }

    public function testMakeFieldsFromObject() {
        $o = new TestClass();

        $fields = ORMUtils::makeFieldsFromObject($o);

        // Test that the inferred field types are correct
        $this->assertEquals("hidden", $fields["TestClass.Id"]->getType());
        $this->assertEquals("text", $fields["TestClass.FieldSmallVarchar"]->getType());
        $this->assertEquals("textarea", $fields["TestClass.FieldLargeVarchar"]->getType());
        $this->assertEquals("text", $fields["TestClass.FieldInteger"]->getType());
        $this->assertEquals("text", $fields["TestClass.FieldFloat"]->getType());
        $this->assertEquals("datetime", $fields["TestClass.FieldTimestamp"]->getType());
        $this->assertEquals("choice", $fields["TestClass.FieldBoolean"]->getType());

        // Test that the boolean field has the correct "Yes"/"No" choices
        $this->assertEquals(["Yes", "No"], $fields["TestClass.FieldBoolean"]->getChoices());

        // Test that requirement inference is correct
        $this->assertTrue($fields["TestClass.RequiredField"]->isRequired());
        $this->assertFalse($fields["TestClass.UnrequiredField"]->isRequired());

        // Test that encryption inference is correct
        $this->assertTrue(ORMUtils::isEncrypted("TestClass.EncryptedField", $o::TABLE_MAP));
        $this->assertFalse(ORMUtils::isEncrypted("TestClass.FieldSmallVarchar", $o::TABLE_MAP));
    }
}