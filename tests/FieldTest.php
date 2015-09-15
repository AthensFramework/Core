<?php

use UWDOEM\Framework\Field\Field;
use UWDOEM\Framework\Field\FieldInterface;
use UWDOEM\Framework\Field\FieldBuilder;


class FieldTest extends PHPUnit_Framework_TestCase
{
    /**
     * @return FieldInterface[]
     */
    public function testedFields() {
        return [
            new Field("literal", "A Literal Field"),
        ];
    }

    public function testBuilder() {
        $type = "type";
        $label = "label";
        $initial = "initial";
        $required = true;
        $choices = ["choice 1", "choice 2"];
        $size = 200;

        $field = FieldBuilder::begin()
            ->setType($type)
            ->setLabel($label)
            ->setInitial($initial)
            ->setRequired($required)
            ->setChoices($choices)
            ->setFieldSize($size)
            ->build();

        $this->assertEquals($type, $field->getType());
        $this->assertEquals($label, $field->getLabel());
        $this->assertEquals($initial, $field->getInitial());
        $this->assertEquals($required, $field->isRequired());
        $this->assertEquals($choices, $field->getChoices());
        $this->assertEquals($size, $field->getSize());
    }

    /**
     * @expectedException              \Exception
     * @expectedExceptionMessageRegExp #Must use ::setType.*#
     */
    public function testBuilderNoTypeException() {
        $field = FieldBuilder::begin()->build();
    }

    /**
     * @expectedException              \Exception
     * @expectedExceptionMessageRegExp #Must use ::setLabel.*#
     */
    public function testBuilderNoLabelException() {
        $field = FieldBuilder::begin()->setType("type")->build();
    }

    /**
     * @expectedException              \Exception
     * @expectedExceptionMessageRegExp #must include choices using ::setChoices.*#
     */
    public function testBuilderNeedsChoicesException() {
        $field = FieldBuilder::begin()->setType(Field::FIELD_TYPE_MULTIPLE_CHOICE)->setLabel("label")->build();
    }

    public function testGetSubmitted() {

        foreach ($this->testedFields() as $field) {
            $data = (string)rand();

            $slug = $field->getSlug();

            $_POST[$slug] = $data;

            $this->assertEquals($data, $field->getSubmitted(), "Failure on class: " . get_class($field));
        }
    }

    public function testWasSubmitted() {

        foreach ($this->testedFields() as $field) {
            $slug = $field->getSlug();

            unset($_POST[$slug]);
            $this->assertEquals(false, $field->wasSubmitted(), "Failure on class: " . get_class($field));

            $_POST[$slug] = (string)rand();
            $this->assertEquals(true, $field->wasSubmitted(), "Failure on class: " . get_class($field));
        }
    }

    public function testGetSetLabel() {
        foreach ($this->testedFields() as $field) {
            $label = (string)rand();

            $field->setLabel($label);
            $this->assertEquals($label, $field->getLabel(), "Failure on class: " . get_class($field));
        }
    }

    public function testSetGetSize() {
        foreach ($this->testedFields() as $field) {
            $size = rand();

            $field->setSize($size);
            $this->assertEquals($size, $field->getSize(), "Failure on class: " . get_class($field));
        }
    }

    public function testGetSetType() {
        foreach ($this->testedFields() as $field) {
            $type = (string)rand();

            $field->setType($type);
            $this->assertEquals($type, $field->getType(), "Failure on class: " . get_class($field));
        }
    }

    public function testAddGetSuffixes() {
        foreach ($this->testedFields() as $field) {
            $suffix = (string)rand();

            $this->assertNotContains($suffix, $field->getSuffixes(), "Failure on class: " . get_class($field));
            $this->assertNotContains($suffix, $field->getSlug(), "Failure on class: " . get_class($field));

            $field->addSuffix($suffix);
            $this->assertContains($suffix, $field->getSuffixes(), "Failure on class: " . get_class($field));
            $this->assertContains($suffix, $field->getSlug(), "Failure on class: " . get_class($field));
        }

    }

    public function testAddGetPrefixes() {
        foreach ($this->testedFields() as $field) {
            $prefix = (string)rand();

            $this->assertNotContains($prefix, $field->getPrefixes(), "Failure on class: " . get_class($field));
            $this->assertNotContains($prefix, $field->getSlug(), "Failure on class: " . get_class($field));

            $field->addPrefix($prefix);
            $this->assertContains($prefix, $field->getPrefixes(), "Failure on class: " . get_class($field));
            $this->assertContains($prefix, $field->getSlug(), "Failure on class: " . get_class($field));
        }
    }

    public function testGetLabelSlug() {
        foreach ($this->testedFields() as $field) {
            $label = utf8_decode(openssl_random_pseudo_bytes(64)) . "a?b%c^d&e*f(g)h-iklmn";
            $label = str_shuffle($label);

            $field->setLabel($label);
            $slug = $field->getLabelSlug();

            // Assert that the slug is lower case
            $this->assertEquals(strtolower($slug), $slug, "Failure on class: " . get_class($field));

            // Assert that the slug has only legal characters
            $this->assertEquals(
                preg_replace(array('/[^a-zA-Z0-9 -]/','/[ -]+/','/^-|-$/'),array('','-',''),$slug),
                $slug,
                "Failure on class: " . get_class($field)
            );

            // Sanity check: assert that the slug has some length and did not pass because it's empty
            $this->assertGreaterThan(8, strlen($slug));
        }

    }

    public function testGetSlug() {
        foreach ($this->testedFields() as $field) {
            $label = utf8_decode(openssl_random_pseudo_bytes(64)) . "a?b%c^d&e*f(g)h-iklmn";
            $label = str_shuffle($label);

            $field->setLabel($label);
            $labelSlug = $field->getLabelSlug();

            $this->assertContains($labelSlug, $field->getSlug(), "Failure on class: " . get_class($field));
        }
    }

    public function testSetGetInitial() {
        foreach ($this->testedFields() as $field) {
            $initial = (string)rand();

            $this->assertNotContains($initial, $field->getInitial(), "Failure on class: " . get_class($field));

            $field->setInitial($initial);
            $this->assertContains($initial, $field->getInitial(), "Failure on class: " . get_class($field));
        }
    }

    public function testAddGetErrors() {
        foreach ($this->testedFields() as $field) {
            $error = (string)rand();

            $this->assertNotContains($error, $field->getErrors(), "Failure on class: " . get_class($field));

            $field->addError($error);
            $this->assertContains($error, $field->getErrors(), "Failure on class: " . get_class($field));
        }
    }

    public function testRemoveErrors()  {
        foreach ($this->testedFields() as $field) {
            $error = (string)rand();

            $field->addError($error);
            $this->assertNotEmpty($field->getErrors(), "Failure on class: " . get_class($field));

            $field->removeErrors();
            $this->assertEmpty($field->getErrors(), "Failure on class: " . get_class($field));
        }
    }

    public function testSetGetRequired() {
        foreach ($this->testedFields() as $field) {

            $field->setRequired(true);
            $this->assertTrue($field->isRequired(), "Failure on class: " . get_class($field));

            $field->setRequired(false);
            $this->assertFalse($field->isRequired(), "Failure on class: " . get_class($field));
        }
    }

    public function testSetGetChoices() {
        foreach ($this->testedFields() as $field) {
            $choices = ["choice 1", "choice 2"];
            $field->setChoices($choices);
            $this->assertEquals($choices, $field->getChoices(), "Failure on class: " . get_class($field));
        }
    }

    public function testSetGetValidatedData() {
        foreach ($this->testedFields() as $field) {
            $data = (string)rand();

            $field->setValidatedData($data);
            $this->assertEquals($data, $field->getValidatedData(), "Failure on class: " . get_class($field));
        }
    }

    public function testValidate() {
        // Field not required, but provided
        foreach ($this->testedFields() as $field) {
            $data = (string)rand();

            $field->setRequired(false);
            $_POST[$field->getSlug()] = $data;

            $field->validate();

            $this->assertTrue($field->isValid(), "Failure on class: " . get_class($field));
            $this->assertEmpty($field->getErrors(), "Failure on class: " . get_class($field));
            $this->assertEquals($data, $field->getValidatedData(), "Failure on class: " . get_class($field));
        }

        // Field not required, not provided
        foreach ($this->testedFields() as $field) {
            $data = (string)rand();

            $field->setRequired(false);
            unset($_POST[$field->getSlug()]);

            $field->validate();

            $this->assertTrue($field->isValid(), "Failure on class: " . get_class($field));
            $this->assertEmpty($field->getErrors(), "Failure on class: " . get_class($field));
            $this->assertEquals(null, $field->getValidatedData(), "Failure on class: " . get_class($field));
        }

        // Field required, and provided
        foreach ($this->testedFields() as $field) {
            $data = (string)rand();

            $field->setRequired(true);
            $_POST[$field->getSlug()] = $data;

            $field->validate();

            $this->assertTrue($field->isValid(), "Failure on class: " . get_class($field));
            $this->assertEmpty($field->getErrors(), "Failure on class: " . get_class($field));
            $this->assertEquals($data, $field->getValidatedData(), "Failure on class: " . get_class($field));
        }

        // Field required, but not provided
        foreach ($this->testedFields() as $field) {
            $data = (string)rand();

            $field->setRequired(true);

            unset($_POST[$field->getSlug()]);

            $field->validate();

            $this->assertFalse($field->isValid(), "Failure on class: " . get_class($field));
            $this->assertNotEmpty($field->getErrors(), "Failure on class: " . get_class($field));
            $this->assertEquals(null, $field->getValidatedData(), "Failure on class: " . get_class($field));
        }

        /* Choice Field */
        // Field has specified choices, submission does not match available choices
        foreach ($this->testedFields() as $field) {
            $field->setChoices(["choice 1", "choice 2"]);
            $field->setType(Field::FIELD_TYPE_CHOICE);
            $data = (string)rand();
            $_POST[$field->getSlug()] = $data;

            $field->validate();

            $this->assertFalse($field->isValid(), "Failure on class: " . get_class($field));
            $this->assertNotEmpty($field->getErrors(), "Failure on class: " . get_class($field));
            $this->assertEquals(null, $field->getValidatedData(), "Failure on class: " . get_class($field));
        }

        // Field has specified choices, submission does match available choices
        foreach ($this->testedFields() as $field) {
            $field->setChoices(["choice 1", "choice 2"]);
            $field->setType(Field::FIELD_TYPE_CHOICE);

            $choice = $field->getChoices()[0];
            $slug = $field->getChoiceSlugs()[0];

            $_POST[$field->getSlug()] = $slug;

            $field->validate();

            $this->assertTrue($field->isValid(), "Failure on class: " . get_class($field));
            $this->assertEmpty($field->getErrors(), "Failure on class: " . get_class($field));
            $this->assertEquals($choice, $field->getValidatedData(), "Failure on class: " . get_class($field));
        }

        /* Multiple-Choice Field */
        // Field has specified choices, submission does not match available choices
        foreach ($this->testedFields() as $field) {
            $field->setChoices(["choice 1", "choice 2"]);
            $field->setType(Field::FIELD_TYPE_MULTIPLE_CHOICE);
            $data = (string)rand();
            $_POST[$field->getSlug()] = [$data];

            $field->validate();

            $this->assertFalse($field->isValid(), "Failure on class: " . get_class($field));
            $this->assertNotEmpty($field->getErrors(), "Failure on class: " . get_class($field));
            $this->assertEquals(null, $field->getValidatedData(), "Failure on class: " . get_class($field));
        }

        // Field has specified choices, submission does match available choices
        foreach ($this->testedFields() as $field) {
            $field->setChoices(["choice 1", "choice 2"]);
            $field->setType(Field::FIELD_TYPE_MULTIPLE_CHOICE);

            $choice = $field->getChoices()[0];
            $slug = $field->getChoiceSlugs()[0];

            $_POST[$field->getSlug()] = [$slug];

            $field->validate();

            $this->assertTrue($field->isValid(), "Failure on class: " . get_class($field));
            $this->assertEmpty($field->getErrors(), "Failure on class: " . get_class($field));
            $this->assertContains($choice, $field->getValidatedData(), "Failure on class: " . get_class($field));
        }
    }
}

