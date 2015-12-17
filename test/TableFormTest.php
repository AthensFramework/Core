<?php

require_once("Mocks.php");

use UWDOEM\Framework\Form\FormBuilder;
use UWDOEM\Framework\Form\FormAction\FormAction;
use UWDOEM\Framework\Field\Field;
use UWDOEM\Framework\Etc\ORMUtils;
use UWDOEM\Framework\FieldBearer\FieldBearerBuilder;
use UWDOEM\Framework\FieldBearer\FieldBearer;
use UWDOEM\Framework\Field\FieldInterface;
use UWDOEM\Framework\Form\FormInterface;
use UWDOEM\Framework\Form\PickAFormBuilder;
use UWDOEM\Framework\Etc\StringUtils;
use UWDOEM\Framework\Row\RowBuilder;
use UWDOEM\Framework\Table\TableFormBuilder;




class TableFormTest extends PHPUnit_Framework_TestCase {

    /**
     * Test basic building
     */
    public function testBuilder() {

        $actions = [new FormAction("label", "method", "")];
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

        $rowMakingFunction = function() {
            return RowBuilder::begin()
                ->addFields([
                    new Field('literal', 'A literal field', []),
                    new Field('literal2', 'A second literal field', [])
                ])
                ->build();
        };

        $form = TableFormBuilder::begin()
            ->setId($id)
            ->setType($type)
            ->setMethod($method)
            ->setTarget($target)
            ->setActions($actions)
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

        /* Test default type/method/target */
        $form = TableFormBuilder::begin()
            ->setId($id)
            ->setRowMakingFunction(function() {})
            ->build();

        $this->assertEquals("base", $form->getType());
        $this->assertEquals("post", $form->getMethod());
        $this->assertEquals("_self", $form->getTarget());
    }

    /**
     * Test prototypical row creation
     */
    public function testPrototypicalRowCreation() {

        $rowMakingFunction = function() {
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
    public function testCreateRowsFromPost() {

        $rowMakingFunction = function() {
            $field1 = new Field('text', 'A text field', []);
            $field2 = new Field('text', 'A second text field', []);

            return RowBuilder::begin()
                ->addFields([
                    "field1" => $field1,
                    "field2" => $field2
                ])
                ->build();
        };

        $form = TableFormBuilder::begin()
            ->setId("f" . (string)rand())
            ->setRowMakingFunction($rowMakingFunction)
            ->build();

        $field1 = $form->getPrototypicalRow()->getFieldBearer()->getFieldByName("field1");

        $field1->addSuffix((string)rand());
        $field1->addSuffix((string)rand());

        $baseSlug = $field1->getSlug();

        $numRows = rand(2, 5);

        $_SERVER["REQUEST_METHOD"] = "POST";
        $data = [];
        for($i = 0; $i < $numRows; $i++) {
            $prefix = (string)(1000*$i + rand(100, 999));
            $data[$i] = (string)rand();

            $_POST["$prefix-$baseSlug"] = $data[$i];
        }

        // Force validation/row creation
        $form->isValid();

        $this->assertEquals($numRows, sizeof($form->getRows()));

        foreach ($form->getRows() as $count => $row) {
            $this->assertEquals($data[$count], $row->getFieldBearer()->getFieldByName("field1")->getSubmitted());
        }

        $_SERVER["REQUEST_METHOD"] = "GET";
    }
}

