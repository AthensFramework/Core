<?php

use UWDOEM\Framework\Etc\Settings;

class MockSettings extends Settings {

    public static function clear() {
        static::$settings["templateDirectories"] = [];
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

}

