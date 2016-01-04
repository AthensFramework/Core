<?php

namespace UWDOEM\Framework\Initializer;

use UWDOEM\Framework\Page\PageInterface;
use UWDOEM\Framework\Table\TableFormInterface;
use UWDOEM\Framework\Visitor\Visitor;
use UWDOEM\Framework\Section\SectionInterface;
use UWDOEM\Framework\Form\FormInterface;
use UWDOEM\Framework\FieldBearer\FieldBearerInterface;
use UWDOEM\Framework\PickA\PickAFormInterface;

/**
 * Class Initializer performs actions on page load to InitizableInterfaces
 *
 * @package UWDOEM\Framework\Initializer
 */
class Initializer extends Visitor
{

    /**
     * @param mixed $child
     * @return void
     */
    protected function visitChild($child)
    {
        // If the given child implements the initializable interface, then initialize it
        if ($child instanceof InitializableInterface) {
            /** @var InitializableInterface $child */
            $child->accept($this);
        }
    }

    /**
     * @param PageInterface $page
     * @return void
     */
    public function visitPage(PageInterface $page)
    {
        $this->visitChild($page->getWritable());
    }

    /**
     * @param SectionInterface $section
     * @return void
     */
    public function visitSection(SectionInterface $section)
    {
        foreach ($section->getWritables() as $writable) {
            $this->visitChild($writable);
        }
    }

    /**
     * @param FieldBearerInterface $fieldBearer
     * @return void
     */
    public function visitFieldBearer(FieldBearerInterface $fieldBearer)
    {
        foreach ($fieldBearer->getFieldBearers() as $bearer) {
            $this->visitChild($bearer);
        }

        $this->suffixFieldBearerFields($fieldBearer);
    }

    /**
     * @param FormInterface $form
     * @return void
     */
    public function visitForm(FormInterface $form)
    {
        $this->suffixFormFields($form);

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $form->isValid() ? $form->onValid(): $form->onInvalid();
        }
    }

    /**
     * @param PickAFormInterface $pickAForm
     * @return void
     */
    public function visitPickAForm(PickAFormInterface $pickAForm)
    {
        $this->visitForm($pickAForm);
    }

    /**
     * @param TableFormInterface $tableForm
     * @return void
     */
    public function visitTableForm(TableFormInterface $tableForm)
    {
        // Suffix fields?
        // Create rows from post?
    }

    /**
     * @param FormInterface $form
     * @param string        $suffix
     * @return void
     */
    protected function suffixFormFieldsFixed(FormInterface $form, $suffix)
    {
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

    /**
     * @param FormInterface $form
     * @param integer       $countBegin
     * @return void
     */
    protected function suffixFormFields(FormInterface $form, $countBegin = 0)
    {
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

    /**
     * @param FieldBearerInterface $fieldBearer
     * @param integer              $countBegin
     * @return void
     */
    protected function suffixFieldBearerFields(FieldBearerInterface $fieldBearer, $countBegin = 0)
    {
        /** @var \UWDOEM\Framework\Field\FieldInterface $field */
        foreach (array_values($fieldBearer->getFields()) as $count => $field) {
            $field->addSuffix($countBegin + $count);
        }
    }
}
