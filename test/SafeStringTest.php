<?php

use UWDOEM\Framework\Etc\SafeString;


class SafeStringTest extends PHPUnit_Framework_TestCase {

    public function testFromString() {
        $string = (string)rand();
        $safe = SafeString::fromString($string);

        $this->assertInstanceOf('UWDOEM\Framework\Etc\SafeString', $safe);
        $this->assertEquals($string, (string)$safe);
    }
}

