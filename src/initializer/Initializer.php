<?php

namespace UWDOEM\Framework\Initializer;

use UWDOEM\Framework\Page\PageInterface;
use UWDOEM\Framework\Visitor\Visitor;
use UWDOEM\Framework\Section\SectionInterface;
use UWDOEM\Framework\Form\FormInterface;


class Initializer extends Visitor {

    protected function visitChild($child) {
        // If the given child implements the initializable interface, then initialize it
        if (array_search(InitializableInterface::class, class_implements($child))) {
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

    public function visitForm(FormInterface $form) {
        // Once subforms are implemented, crawl them first

        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $form->isValid() ? $form->onValid(): $form->onInvalid();
        }
    }

}