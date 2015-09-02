<?php

use UWDOEM\Framework\Etc\Settings;


class SettingsTest extends PHPUnit_Framework_TestCase {

    public function testAddTemplateTheme() {
        Settings::addTemplateTheme("theme1");
        Settings::addTemplateTheme("theme2");

        $result = Settings::getTemplateThemes();

        $this->assertContains("theme1", $result);
        $this->assertContains("theme2", $result);
        $this->assertEquals(2, sizeof($result));

    }

}

