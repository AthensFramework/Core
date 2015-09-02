<?php

use UWDOEM\Framework\Etc\Settings;

class MockSettings extends Settings {
    
    public static function clear() {
        static::$settings = [];
    }
}


class SettingsTest extends PHPUnit_Framework_TestCase {

    public function testAddTemplateTheme() {
        MockSettings::addTemplateTheme("theme1");
        MockSettings::addTemplateTheme("theme2");

        $result = MockSettings::getTemplateThemes();

        $this->assertContains("theme1", $result);
        $this->assertContains("theme2", $result);
        $this->assertEquals(2, sizeof($result));

        MockSettings::clear();

    }

}

