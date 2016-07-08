<?php

namespace Athens\Core\Initializer;

use Athens\Core\Page\PageInterface;
use Athens\Core\Table\TableFormInterface;
use Athens\Core\Visitor\Visitor;
use Athens\Core\Section\SectionInterface;
use Athens\Core\Form\FormInterface;
use Athens\Core\FieldBearer\FieldBearerInterface;
use Athens\Core\PickA\PickAFormInterface;
use Athens\Core\WritableBearer\WritableBearerInterface;

/**
 * Class Initializer performs actions on page load to InitizableInterfaces
 *
 * @package Athens\Core\Initializer
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
        $this->visitChild($page->getWritableBearer());
    }

    /**
     * @param SectionInterface $section
     * @return void
     */
    public function visitSection(SectionInterface $section)
    {
        $this->visitChild($section->getWritableBearer());
    }

    /**
     * @param WritableBearerInterface $writableBearer
     * @return void
     */
    public function visitWritableBearer(WritableBearerInterface $writableBearer)
    {
        foreach ($writableBearer->getWritables() as $writable) {
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
        /** @var \Athens\Core\Field\FieldInterface $field */
        foreach (array_values($fieldBearer->getFields()) as $count => $field) {
            $field->addSuffix($countBegin + $count);
        }
    }
}
