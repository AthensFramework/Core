<?php

require_once('Mocks.php');

use UWDOEM\Framework\Form\FormBuilder;
use UWDOEM\Framework\Form\FormAction\FormAction;
use UWDOEM\Framework\PickA\PickAFormBuilder;
use UWDOEM\Framework\Etc\StringUtils;


class PickAFormTest extends PHPUnit_Framework_TestCase {


    public function testPickAFormBuilding() {
        $actions = [new FormAction("label", "method", "")];

        $id = "f" . (string)rand();
        $type = "t" . (string)rand();

        $forms = [];
        $labels = [];
        for ($i = 0; $i < 3; $i++) {
            $forms[] = FormBuilder::begin()
                ->setId("f-" . (string)rand())
                ->addFieldBearers([new MockFieldBearer])
                ->build();
            $labels[] = "Form $i";
        }

        $pickAForm = PickAFormBuilder::begin()
            ->setId($id)
            ->setType($type)
            ->addLabel("Label Text")
            ->addForms([
                $labels[0] => $forms[0],
                $labels[1] => $forms[1]
            ])
            ->addLabel("Label Text2")
            ->addForms([
                $labels[2] => $forms[2]
            ])
            ->setActions($actions)
            ->build();

        $this->assertEquals(array_combine($labels, $forms), $pickAForm->getSubForms());
        $this->assertEquals($actions, array_values($pickAForm->getActions()));
        $this->assertEquals($id, $pickAForm->getId());
        $this->assertEquals($type, $pickAForm->getType());
    }

    public function testGetSelectedSlug() {
        $fieldBearers = [];
        $forms = [];
        $labels = [];
        for ($i = 0; $i < 2; $i++) {
            $fieldBearers[] = new MockFieldBearer;
            $labels[] = "Form $i";
            $forms[] = FormBuilder::begin()
                ->setId("f-" . (string)rand())
                ->addFieldBearers([$fieldBearers[$i]])
                ->build();
        }

        $pickAForm = PickAFormBuilder::begin()
            ->setId("f-" . (string)rand())
            ->addLabel("Label Text")
            ->addForms([
                $labels[0] => $forms[0],
                $labels[1] => $forms[1]
            ])
            ->build();

        $selectedForm = 0;
        $unselectedForm = 1;

        $_SERVER['REQUEST_METHOD'] = "POST";
        $_POST[$pickAForm->getId()] = StringUtils::slugify($labels[$selectedForm]);

        $this->assertEquals(StringUtils::slugify($labels[$selectedForm]), $pickAForm->getSelectedSlug());

        $_SERVER['REQUEST_METHOD'] = "GET";
        $_POST = [];
    }

    /**
     * If no form is selected, then the pick a form is not valid.
     */
    public function testPickAFormValidationWithNoSelection() {
        $forms = [];
        $labels = [];
        for ($i = 0; $i < 2; $i++) {
            $labels[] = "Form $i";
            $forms[] = FormBuilder::begin()
                ->setId("f-" . (string)rand())
                ->addFieldBearers([new MockFieldBearer])
                ->build();
        }

        $pickAForm = PickAFormBuilder::begin()
            ->setId("f-" . (string)rand())
            ->addLabel("Label Text")
            ->addForms([
                $labels[0] => $forms[0],
                $labels[1] => $forms[1]
            ])
            ->build();

        $this->assertFalse($pickAForm->isValid());
    }

    public function testPickAFormGetSelectedForm() {
        $fieldBearers = [];
        $forms = [];
        $labels = [];
        for ($i = 0; $i < 2; $i++) {
            $fieldBearers[] = new MockFieldBearer;
            $labels[] = "Form $i";
            $forms[] = FormBuilder::begin()
                ->setId("f-" . (string)rand())
                ->addFieldBearers([$fieldBearers[$i]])
                ->build();
        }

        $pickAForm = PickAFormBuilder::begin()
            ->setId("f-" . (string)rand())
            ->addLabel("Label Text")
            ->addForms([
                $labels[0] => $forms[0],
                $labels[1] => $forms[1]
            ])
            ->build();

        $selectedForm = 0;
        $unselectedForm = 1;

        $_SERVER['REQUEST_METHOD'] = "POST";
        $_POST[$pickAForm->getId()] = StringUtils::slugify($labels[$selectedForm]);

        $this->assertEquals($forms[$selectedForm], $pickAForm->getSelectedForm());

        $_SERVER['REQUEST_METHOD'] = "GET";
        $_POST = [];
    }

    /**
     * If a form is selected, then validation passes to the selected subform.
     */
    public function testPickAFormValidationWithSelection() {
        $fieldBearers = [];
        $forms = [];
        $labels = [];
        for ($i = 0; $i < 2; $i++) {
            $fieldBearers[] = new MockFieldBearer;
            $labels[] = "Form $i";
            $forms[] = FormBuilder::begin()
                ->setId("f-" . (string)rand())
                ->addFieldBearers([$fieldBearers[$i]])
                ->build();
        }

        $pickAForm = PickAFormBuilder::begin()
            ->setId("f-" . (string)rand())
            ->addLabel("Label Text")
            ->addForms([
                $labels[0] => $forms[0],
                $labels[1] => $forms[1]
            ])
            ->build();

        $selectedForm = 0;
        $unselectedForm = 1;

        $_SERVER['REQUEST_METHOD'] = "POST";
        $_POST[$pickAForm->getId()] = StringUtils::slugify($labels[$selectedForm]);

        $this->assertTrue($pickAForm->isValid());

        $pickAForm->onValid();

        $this->assertTrue($fieldBearers[$selectedForm]->saved);
        $this->assertFalse($fieldBearers[$unselectedForm]->saved);

        $_SERVER['REQUEST_METHOD'] = "GET";
        $_POST = [];
    }
}

