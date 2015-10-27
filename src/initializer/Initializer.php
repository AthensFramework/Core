<?php

namespace UWDOEM\Framework\Initializer;

use UWDOEM\Framework\Page\PageInterface;
use UWDOEM\Framework\Visitor\Visitor;
use UWDOEM\Framework\Section\SectionInterface;
use UWDOEM\Framework\Form\FormInterface;
use UWDOEM\Framework\FieldBearer\FieldBearerInterface;


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

        /** @var \UWDOEM\Framework\Field\FieldInterface $field */
        foreach (array_values($fieldBearer->getFields()) as $count => $field) {
            $field->addSuffix($count);
        }

    }

    public function visitForm(FormInterface $form) {
        foreach (array_values($form->getSubForms()) as $count => $subForm) {
            foreach ($subForm->getFieldBearer()->getFields() as $field) {
                $field->addSuffix($count);
            }

            $this->visitForm($subForm);
        }

        $this->visitChild($form->getFieldBearer());

        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $form->isValid() ? $form->onValid(): $form->onInvalid();
        }
    }

}