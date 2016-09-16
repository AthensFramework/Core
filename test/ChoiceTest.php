<?php

namespace Athens\Core\Test;

use Exception;

use PHPUnit_Framework_TestCase;

use Athens\Core\Choice\ChoiceBuilder;
use Athens\Core\Choice\ChoiceInterface;

class ChoiceTest extends PHPUnit_Framework_TestCase
{

    public function testBuilder()
    {
        $id = "c" . (string)rand();
        $classes = ["c1" . (string)rand(), "c2" . (string)rand()];
        $data = [
            "k1" . (string)rand() => "v1" . (string)rand(),
            "k2" . (string)rand() => "v2" . (string)rand(),
        ];
        $value = "c" . (string)rand();
        $alias = "c" . (string)rand();
        
        $choice = ChoiceBuilder::begin()
            ->setId($id)
            ->addClass($classes[0])
            ->addClass($classes[1])
            ->addData(array_keys($data)[0], array_values($data)[0])
            ->addData(array_keys($data)[1], array_values($data)[1])
            ->setValue($value)
            ->setAlias($alias)
            ->build();
        
        $this->assertInstanceOf(ChoiceInterface::class, $choice);
        
        $this->assertEquals($id, $choice->getId());
        $this->assertEquals($classes, $choice->getClasses());
        $this->assertEquals($data, $choice->getData());
        
        $this->assertEquals($value, $choice->getValue());
        $this->assertEquals($alias, $choice->getAlias());
    }

    /**
     * If an alias is not provided to ChoiceBuilder, ChoiceBuilder
     * shall provide *alias* as the string representation of *value*
     */
    public function testAliasNotRequired()
    {
        $value = rand();

        $choice = ChoiceBuilder::begin()
            ->setValue($value)
            ->build();

        $this->assertEquals($value, $choice->getValue());
        $this->assertTrue(is_string($choice->getAlias()));
        $this->assertEquals((string)$value, $choice->getAlias());
    }

    /**
     * If a value is not provided to ChoiceBuilder, ChoiceBuilder
     * shall throw an exception.
     * 
     * @expectedException              Exception
     * @expectedExceptionMessageRegExp #Must use ::setValue.*#
     */
    public function testValueIsRequired()
    {
        ChoiceBuilder::begin()
            ->setAlias((string)rand())
            ->build();
    }

}
