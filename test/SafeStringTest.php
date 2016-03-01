<?php

namespace Athens\Core\Test;

use PHPUnit_Framework_TestCase;

use Athens\Core\Etc\SafeString;

class SafeStringTest extends PHPUnit_Framework_TestCase
{

    public function testFromString()
    {
        $string = (string)rand();
        $safe = SafeString::fromString($string);

        $this->assertInstanceOf('Athens\Core\Etc\SafeString', $safe);
        $this->assertEquals($string, (string)$safe);
    }
}
