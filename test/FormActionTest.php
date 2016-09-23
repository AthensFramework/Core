<?php

namespace Athens\Core\Test;

use PHPUnit_Framework_TestCase;

use Athens\Core\FormAction\FormActionBuilder;

class FormActionTest extends PHPUnit_Framework_TestCase
{

    /**
     * Basic tests for the FormAction builder class.
     *
     * @throws \Exception
     */
    public function testBuilder()
    {
        $type = 't' . (string)rand();
        $label = 'l' . (string)rand();
        $target = 't' . (string)rand();
        
        $formAction = FormActionBuilder::begin()
            ->setType($type)
            ->setLabel($label)
            ->setTarget($target)
            ->build();
        
        $this->assertEquals($type, $formAction->getType());
        $this->assertEquals($label, $formAction->getLabel());
        $this->assertEquals($target, $formAction->getTarget());
    }

}
