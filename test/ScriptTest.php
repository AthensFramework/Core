<?php

namespace Athens\Core\Test;

use PHPUnit_Framework_TestCase;

use Athens\Core\Script\ScriptBuilder;

class ScriptTest extends PHPUnit_Framework_TestCase
{

    public function testBuilder()
    {
        $type = "type";
        $classes = ["class1", "class2"];
        $contents = "example contents";

        $script = ScriptBuilder::begin()
            ->setType($type)
            ->addClass($classes[0])
            ->addClass($classes[1])
            ->setContents($contents)
            ->build();

        $this->assertEquals($type, $script->getType());
        $this->assertEquals($contents, $script->getContents());
        $this->assertContains($classes[0], $script->getClasses());
        $this->assertContains($classes[1], $script->getClasses());
    }
}
