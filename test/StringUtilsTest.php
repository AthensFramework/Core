<?php

use UWDOEM\Framework\Etc\StringUtils;


class StringUtilsTest extends PHPUnit_Framework_TestCase {

    public function testSlugify() {

        // Assert that it will correctly convert a simple string
        $string = "I am the very model of a modern Major General";
        $this->assertEquals("i-am-the-very-model-of-a-modern-major-general", StringUtils::slugify($string));

        // Assert that it will remove non-alphanumeric characters
        $string = "^a#%5m4ll3r^^7357!@ 57r1n6";
        $this->assertEquals("a5m4ll3r7357-57r1n6", StringUtils::slugify($string));

        // Assert that it will trim numbers from the beginning of the string
        $string = "2^4a#%5m4ll3r^^7357!@ 57r1n6";
        $this->assertEquals("24a5m4ll3r7357-57r1n6", StringUtils::slugify($string));

    }

    public function testToUpperCamelCase() {

        $string = "I am the very-model of_a modern Major General";
        $this->assertEquals("IAmTheVeryModelOfAModernMajorGeneral", StringUtils::toUpperCamelCase($string));

    }

    public function testToTitleCase() {

        $string = "i am the very-model of_a modern Major General";
        $this->assertEquals("I Am the Very Model of a Modern Major General", StringUtils::toTitleCase($string));

    }
}

