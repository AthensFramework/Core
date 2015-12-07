<?php

use UWDOEM\Framework\Etc\Settings;

class MockSettings extends Settings {

    public static function clear() {
        static::$settings["templateDirectories"] = [];
        static::$settings["projectCSS"] = [];
        static::$settings["projectJS"] = [];
        static::$settings["defaultPagination"] = 12;
    }
}


class SettingsTest extends PHPUnit_Framework_TestCase {

    public function testAddTemplateTheme() {
        MockSettings::addTemplateTheme("theme1");
        MockSettings::addTemplateTheme("theme2");
        MockSettings::addTemplateDirectory("/path/to/template/theme");

        $result = MockSettings::getTemplateDirectories();

        $this->assertContains("theme1", $result[0]);
        $this->assertContains("theme2", $result[1]);
        $this->assertContains("/path/to/template/theme", $result[2]);
        $this->assertEquals(3, sizeof($result));

        MockSettings::clear();
    }

    public function testAddProjectJS() {
        $file1 = "/path/to/file/1.js";
        $file2 = "/path/to/file/2.js";

        MockSettings::addProjectJS($file1);
        MockSettings::addProjectJS($file2);

        $result = MockSettings::getProjectJS();

        $this->assertContains($file1, $result);
        $this->assertContains($file2, $result);
        $this->assertEquals(2, sizeof($result));

        MockSettings::clear();
    }

    public function testAddProjectCSS() {
        $file1 = "/path/to/file/1.css";
        $file2 = "/path/to/file/2.css";

        MockSettings::addProjectCSS($file1);
        MockSettings::addProjectCSS($file2);

        $result = MockSettings::getProjectCSS();

        $this->assertContains($file1, $result);
        $this->assertContains($file2, $result);
        $this->assertEquals(2, sizeof($result));

        MockSettings::clear();
    }

    public function testSetDefaultPagination() {
        $value = rand();

        MockSettings::setDefaultPagination($value);

        $result = MockSettings::getDefaultPagination();

        $this->assertEquals($value, $result);

        MockSettings::clear();
    }

}

