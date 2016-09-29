<?php

namespace Athens\Core\Test;

use Exception;

use PHPUnit_Framework_TestCase;

use Athens\Core\Test\Mock\MockSettings;

class SettingsTest extends PHPUnit_Framework_TestCase
{

    public function testAddToArraySetting()
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

    public function testSetNonArrayAttribute()
    {
        $value = rand();

        MockSettings::getInstance()->setDefaultPagination($value);

        $result = MockSettings::getInstance()->getDefaultPagination();

        $this->assertEquals($value, $result);

        MockSettings::getInstance()->clear();
    }

    /**
     * @expectedException              Exception
     * @expectedExceptionMessageRegExp #Method foo not found.*#
     */
    public function testTryUseBadMethod()
    {
        MockSettings::getInstance()->foo();
    }

    /**
     * @expectedException              Exception
     * @expectedExceptionMessageRegExp #Setting projectJS is an array. Try using ::add.*#
     */
    public function testTrySetArrayAttribute()
    {
        MockSettings::getInstance()->setProjectJS(rand());
    }

    /**
     * @expectedException              Exception
     * @expectedExceptionMessageRegExp #Setting defaultPagination is not an array. Try using ::set.*#
     */
    public function testTryAddToNonArrayAttribute()
    {
        MockSettings::getInstance()->addDefaultPagination(rand());
    }

    /**
     * @expectedException              Exception
     * @expectedExceptionMessageRegExp #Setting someNonExistentAttribute not found among.*#
     */
    public function testTrySetNonExistentAttribute()
    {
        MockSettings::getInstance()->setSomeNonExistentAttribute(rand());
    }
}
