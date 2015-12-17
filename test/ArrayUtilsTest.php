<?php

namespace UWDOEM\Framework\Test;

use PHPUnit_Framework_TestCase;

use UWDOEM\Framework\Etc\ArrayUtils;

class ArrayUtilsTest extends PHPUnit_Framework_TestCase
{

    public function testFindOrDefault()
    {

        $array = [
            "one" => "hat",
            "two" => "cat",
            "three" => "sat",
        ];

        $default = (string)rand();

        // ArrayUtils finds the correct value when the key is present.
        $this->assertEquals($array["one"], ArrayUtils::findOrDefault("one", $array, $default));

        // ArrayUtils provides the default when the key is not present.
        $this->assertEquals($default, ArrayUtils::findOrDefault("four", $array, $default));

    }
}
