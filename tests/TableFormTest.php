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

        $rowBuilder = RowBuilder::begin()
            ->addFields([
                new Field('literal', 'A literal field', []),
                new Field('literal2', 'A second literal field', [])
            ]);

        $form = TableFormBuilder::begin()
            ->setActions($actions)
            ->setOnInvalidFunc($onInvalidFunc)
            ->setOnValidFunc($onValidFunc)
            ->setRowBuilder($rowBuilder)
            ->build();

        $this->assertEquals($actions, $form->getActions());

        $this->assertEquals("valid", $form->onValid());
        $this->assertEquals("invalid", $form->onInvalid());
    }

    /**
     * Test prototypical row creation
     */
    public function testPrototypicalRowCreation() {

        $rowBuilder = RowBuilder::begin()
            ->addFields([
                new Field('literal', 'A literal field', []),
                new Field('literal2', 'A second literal field', [])
            ]);

        $form = TableFormBuilder::begin()
            ->setRowBuilder($rowBuilder)
            ->build();

        $this->assertEquals(
            $rowBuilder->build()->getFieldBearer()->getFields(),
            $form->getPrototypicalRow()->getFieldBearer()->getFields()
        );
    }

    /**
     * Test row creation from POST
     */
    public function testCreateRowsFromPost() {

        $field1 = new Field('text', 'A text field', []);
        $field2 = new Field('text', 'A second text field', []);

        $rowBuilder = RowBuilder::begin()
            ->addFields([
                "field1" => $field1,
                "field2" => $field2
            ]);

        $form = TableFormBuilder::begin()
            ->setRowBuilder($rowBuilder)
            ->build();

        $field1->addSuffix((string)rand());
        $field1->addSuffix((string)rand());
        $baseSlug = $field1->getSlug();

        $numRows = rand(2, 5);

        $_SERVER["REQUEST_METHOD"] = "POST";
        for($i = 0; $i < $numRows; $i++) {
            $prefix = (string)(1000*$i + rand(100, 999));

            $_POST["$prefix-$baseSlug"] = true;
        }

        // Force validation/row creation
        $form->isValid();

        $this->assertEquals($numRows, sizeof($form->getRows()));

        $_SERVER["REQUEST_METHOD"] = "GET";
    }
}

