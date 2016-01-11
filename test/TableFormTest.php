<?php

namespace UWDOEM\Framework\Test;

use PHPUnit_Framework_TestCase;

use UWDOEM\Framework\FieldBearer\FieldBearerBuilder;
use UWDOEM\Framework\Form\FormAction\FormAction;
use UWDOEM\Framework\Field\Field;
use UWDOEM\Framework\Row\RowBuilder;
use UWDOEM\Framework\Table\TableFormBuilder;
use UWDOEM\Framework\Field\FieldBuilder;

use UWDOEM\Framework\Test\Mock\MockRow;
use UWDOEM\Framework\Test\Mock\MockFieldBearer;

class TableFormTest extends PHPUnit_Framework_TestCase
{

    /**
     * Test basic building
     */
    public function testBuilder()
    {

        $actions = [new FormAction([], "label", "method", "")];
        $onValidFunc = function () {
            return "valid";
        };
        $onInvalidFunc = function () {
            return "invalid";
        };

        $id = "f" . (string)rand();
        $type= "t" . (string)rand();
        $method = "m" . (string)rand();
        $target = "t" . (string)rand();

        $rowMakingFunction = function () {
            return RowBuilder::begin()
                ->addFields([
                    new Field('literal', 'A literal field', []),
                    new Field('literal2', 'A second literal field', [])
                ])
                ->build();
        };

        $initialRows = [
            $rowMakingFunction(),
            $rowMakingFunction(),
        ];

        $form = TableFormBuilder::begin()
            ->setId($id)
            ->setType($type)
            ->setMethod($method)
            ->setTarget($target)
            ->setActions($actions)
            ->setRows($initialRows)
            ->setOnInvalidFunc($onInvalidFunc)
            ->setOnValidFunc($onValidFunc)
            ->setRowMakingFunction($rowMakingFunction)
            ->build();

        $this->assertEquals($actions, $form->getActions());

        $this->assertEquals("valid", $form->onValid());
        $this->assertEquals("invalid", $form->onInvalid());
        $this->assertEquals($id, $form->getId());
        $this->assertEquals($type, $form->getType());
        $this->assertEquals($method, $form->getMethod());
        $this->assertEquals($target, $form->getTarget());

        $this->assertEquals($initialRows, $form->getRows());

        /* Test default type/method/target */
        $form = TableFormBuilder::begin()
            ->setId($id)
            ->build();

        $this->assertEquals("base", $form->getType());
        $this->assertEquals("post", $form->getMethod());
        $this->assertEquals("_self", $form->getTarget());
    }

    /**
     * @expectedException              \Exception
     * @expectedExceptionMessageRegExp #If \$rowMakingFunction is provided and callable.*#
     */
    public function testExceptionIfRowMakerDoesntMakeRows()
    {
        $form = TableFormBuilder::begin()
            ->setId((string)rand())
            ->setRowMakingFunction(function () {
            })
            ->build();
    }

    /**
     * Test prototypical row creation
     */
    public function testPrototypicalRowCreation()
    {

        $rowMakingFunction = function () {
            return RowBuilder::begin()
                ->addFields([
                    new Field('literal', 'A literal field', []),
                    new Field('literal2', 'A second literal field', [])
                ])
                ->build();
        };

        $form = TableFormBuilder::begin()
            ->setId("f" . (string)rand())
            ->setRowMakingFunction($rowMakingFunction)
            ->build();

        $this->assertEquals(
            $rowMakingFunction()->getFieldBearer()->getFields(),
            $form->getPrototypicalRow()->getFieldBearer()->getFields()
        );
    }

    /**
     * Test row creation from POST
     */
    public function testCreateRowsFromPost()
    {

        $rowMakingFunction = function () {
            $field1 = new Field('text', 'A text field', []);
            $field2 = new Field('text', 'A second text field', []);

            return RowBuilder::begin()
                ->addFields([
                    "field1" => $field1,
                    "field2" => $field2
                ])
                ->build();
        };

        $initialRows = [
            $rowMakingFunction(),
            $rowMakingFunction(),
        ];

        $form = TableFormBuilder::begin()
            ->setId("f" . (string)rand())
            ->setRowMakingFunction($rowMakingFunction)
            ->setRows($initialRows)
            ->build();

        $field1 = $form->getPrototypicalRow()->getFieldBearer()->getFieldByName("field1");

        $field1->addSuffix((string)rand());
        $field1->addSuffix((string)rand());

        $baseSlug = $field1->getSlug();

        $numRows = rand(2, 5);

        $_SERVER["REQUEST_METHOD"] = "POST";
        $data = [];
        for ($i = 0; $i < $numRows; $i++) {
            $prefix = (string)(1000*$i + rand(100, 999));
            $data[$i] = (string)rand();

            $_POST["$prefix-$baseSlug"] = $data[$i];
        }

        // Force validation/row creation
        $form->isValid();

        $formRows = $form->getRows();

        $this->assertEquals(
            $numRows + sizeof($initialRows),
            sizeof($formRows)
        );

        foreach ($initialRows as $row) {
            $this->assertContains($row, $formRows);
        }

        $submittedRows = Utils::arrayDiffObjects($formRows, $initialRows);

        foreach (array_values($submittedRows) as $count => $row) {
            $this->assertEquals($data[$count], $row->getFieldBearer()->getFieldByName("field1")->getSubmitted());
        }

        $_SERVER["REQUEST_METHOD"] = "GET";
    }

    public function testDefaultOnValid()
    {
        $row = new MockRow();
        $fieldBearer = new MockFieldBearer();
        $row->setFieldBearer($fieldBearer);

        $form = TableFormBuilder::begin()
            ->setId("f" . (string)rand())
            ->setRows([$row])
            ->build();

        $this->assertFalse($fieldBearer->saved);

        $form->onValid();

        $this->assertTrue($fieldBearer->saved);
    }

    public function testDefaultOnInvalid()
    {
        $row = new MockRow();

        $field1 = FieldBuilder::begin()
            ->setLabel("Literal Field")
            ->setType(Field::FIELD_TYPE_LITERAL)
            ->setInitial("")
            ->build();

        $field2 = FieldBuilder::begin()
            ->setLabel("Text Field")
            ->setType(Field::FIELD_TYPE_TEXT)
            ->setInitial("")
            ->build();

        $fieldBearer = FieldBearerBuilder::begin()
            ->addFields([
                "field1" => $field1,
                "field2" => $field2,
            ])
            ->build();

        $field1Submission = "s" . (string)rand();
        $field2Submission = "s" . (string)rand();

        $_POST[$field1->getSlug()] = $field1Submission;
        $_POST[$field2->getSlug()] = $field2Submission;

        $row->setFieldBearer($fieldBearer);

        $form = TableFormBuilder::begin()
            ->setId("f" . (string)rand())
            ->setRows([$row])
            ->build();

        $this->assertNotEquals($field1Submission, $fieldBearer->getFieldByName("field1")->getInitial());
        $this->assertNotEquals($field2Submission, $fieldBearer->getFieldByName("field2")->getInitial());

        // Force the default onInvalid action
        $form->onInvalid();

        // A literal field SHALL NOT have its initial replaced by its submission
        $this->assertNotEquals($field1Submission, $fieldBearer->getFieldByName("field1")->getInitial());

        // A non-literal field SHALL have its initial replaced by its submission
        $this->assertEquals($field2Submission, $fieldBearer->getFieldByName("field2")->getInitial());

        $_POST[$field1->getSlug()] = null;
        $_POST[$field2->getSlug()] = null;
    }
}
