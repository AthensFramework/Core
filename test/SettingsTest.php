<?php

namespace Athens\Core\Test;

use PHPUnit_Framework_TestCase;

use Athens\Core\Test\Mock\MockSettings;

class SettingsTest extends PHPUnit_Framework_TestCase
{

    public function testAddProjectJS()
    {
        $file1 = "/path/to/file/1.js";
        $file2 = "/path/to/file/2.js";

        MockSettings::getInstance()->addProjectJS($file1);
        MockSettings::getInstance()->addProjectJS($file2);

        $result = MockSettings::getInstance()->getProjectJS();

        $this->assertContains($file1, $result);
        $this->assertContains($file2, $result);
        $this->assertEquals(2, sizeof($result));

        MockSettings::getInstance()->clear();
    }

    public function testAddProjectCSS()
    {
        $file1 = "/path/to/file/1.css";
        $file2 = "/path/to/file/2.css";

        MockSettings::getInstance()->addProjectCSS($file1);
        MockSettings::getInstance()->addProjectCSS($file2);

        $result = MockSettings::getInstance()->getProjectCSS();

        $this->assertContains($file1, $result);
        $this->assertContains($file2, $result);
        $this->assertEquals(2, sizeof($result));

        MockSettings::getInstance()->clear();
    }

    public function testSetDefaultPagination()
    {
        $value = rand();

        MockSettings::getInstance()->setDefaultPagination($value);

        $result = MockSettings::getInstance()->getDefaultPagination();

        $this->assertEquals($value, $result);

        MockSettings::getInstance()->clear();
    }
}
