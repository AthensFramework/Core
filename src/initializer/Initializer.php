<?php

namespace Athens\Core\Initializer;

use Athens\Core\Page\PageInterface;
use Athens\Core\Table\TableFormInterface;
use Athens\Core\Section\SectionInterface;
use Athens\Core\Form\FormInterface;
use Athens\Core\WritableBearer\WritableBearerInterface;
use Athens\Core\PickA\PickAFormInterface;
use Athens\Core\Visitor\VisitorInterface;
use Athens\Core\Field\FieldInterface;

/**
 * Class Initializer performs actions on page load to InitizableInterfaces
 *
 * @package Athens\Core\Initializer
 */
class Initializer implements VisitorInterface
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
     * @param FormInterface $form
     * @return void
     */
    public function visitForm(FormInterface $form)
    {
        $this->suffixFormFields($form);

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $form->isValid() === true ? $form->onValid(): $form->onInvalid();
        }
    }

    /**
     * @param FormInterface $form
     * @param string        $suffix
     * @return void
     */
    protected function suffixFormFieldsFixed(FormInterface $form, $suffix)
    {
        foreach ($form->getWritableBearer()->getWritables() as $writable) {
            if ($writable instanceof FieldInterface) {
                $writable->addSuffix($suffix);
            }
        }

        foreach ($form->getWritableBearer()->getWritables() as $writable) {
            if ($writable instanceof FormInterface) {
                foreach ($writable->getWritableBearer()->getWritables() as $subwritable) {
                    if ($subwritable instanceof FieldInterface) {
                        $subwritable->addSuffix($suffix);
                    }
                }

                $this->suffixFormFieldsFixed($writable, $suffix);
            }
        }
    }

    /**
     * @param FormInterface $form
     * @param integer       $countBegin
     * @return void
     */
    protected function suffixFormFields(FormInterface $form, $countBegin = 0)
    {
        foreach ($form->getWritableBearer()->getWritables() as $writable) {
            if ($writable instanceof FieldInterface) {
                $writable->addSuffix(0);
            }
        }

        $count = 1;
        foreach ($form->getWritableBearer()->getWritables() as $writable) {
            if ($writable instanceof FormInterface) {
                $this->suffixFormFieldsFixed($writable, $count);
                $this->suffixFormFields($writable);
                
                $count++;
            }
        }


        $this->suffixFieldBearerFields($form->getWritableBearer());
    }

    /**
     * @param WritableBearerInterface $fieldBearer
     * @param integer                 $countBegin
     * @return void
     */
    protected function suffixFieldBearerFields(WritableBearerInterface $fieldBearer, $countBegin = 0)
    {
        /** @var \Athens\Core\Field\FieldInterface $writable */
        foreach (array_values($fieldBearer->getWritables()) as $count => $writable) {
            if ($writable instanceof FieldInterface) {
                $writable->addSuffix($countBegin + $count);
            }
        }
    }
}
