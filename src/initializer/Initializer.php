<?php

namespace UWDOEM\Framework\Initializer;

use UWDOEM\Framework\Page\PageInterface;
use UWDOEM\Framework\Visitor\Visitor;
use UWDOEM\Framework\Section\SectionInterface;
use UWDOEM\Framework\Form\FormInterface;
use UWDOEM\Framework\FieldBearer\FieldBearerInterface;
use UWDOEM\Framework\Form\PickAFormInterface;


class Initializer extends Visitor {

    protected function visitChild($child) {
        // If the given child implements the initializable interface, then initialize it
        if ($child instanceof InitializableInterface) {
            /** @var InitializableInterface $child */
            $child->accept($this);
        }
    }

    public function visitPage(PageInterface $page) {
        $this->visitChild($page->getWritable());
    }

    public function visitSection(SectionInterface $section) {
        foreach ($section->getWritables() as $writable) {
            $this->visitChild($writable);
        }
    }

    public function visitFieldBearer(FieldBearerInterface $fieldBearer) {
        foreach ($fieldBearer->getFieldBearers() as $bearer) {
            $this->visitChild($bearer);
        }

        $this->suffixFieldBearerFields($fieldBearer);
    }

    public function visitForm(FormInterface $form) {
        $this->suffixFormFields($form);

        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $form->isValid() ? $form->onValid(): $form->onInvalid();
        }
    }

    public function visitPickAForm(PickAFormInterface $pickAForm) {
        $this->visitForm($pickAForm);
    }

    protected function suffixFormFieldsFixed(FormInterface $form, $suffix) {
        foreach ($form->getFieldBearer()->getFields() as $field) {
            $field->addSuffix($suffix);
        }

        foreach ($form->getSubForms() as $subform) {
            foreach ($subform->getFieldBearer()->getFields() as $field) {
                $field->addSuffix($suffix);
            }

            $this->suffixFormFieldsFixed($subform, $suffix);
        }
    }

    protected function suffixFormFields(FormInterface $form, $countBegin = 0) {
        foreach ($form->getFieldBearer()->getFields() as $field) {
            $field->addSuffix(0);
        }

        $count = 1;
        foreach ($form->getSubForms() as $subform) {
            $this->suffixFormFieldsFixed($subform, $count);
            $count++;

            $this->suffixFormFields($subform);
        }


        $this->suffixFieldBearerFields($form->getFieldBearer());
    }

    protected function suffixFieldBearerFields(FieldBearerInterface $fieldBearer, $countBegin = 0) {
        /** @var \UWDOEM\Framework\Field\FieldInterface $field */
        foreach (array_values($fieldBearer->getFields()) as $count => $field) {
            $field->addSuffix($countBegin + $count);
        }
    }

}