<?php

namespace UWDOEM\Framework\Etc;


class Settings {

    protected static $settings = [
        "templateDirectories" => []
    ];

    protected function __construct() {}

    public static function addTemplateTheme($theme) {
        $templateDirectory = dirname(__FILE__) . '/../writer/templates/' . $theme;
        static::addTemplateDirectory($templateDirectory);
    }

    public static function addTemplateDirectory($directory) {
        static::$settings["templateDirectories"][] = $directory;
    }

    public static function getTemplateDirectories() {
        return static::getSetting("templateDirectories");
    }

    protected static function getSetting($key) {
        if (array_key_exists($key, static::$settings)) {
            return static::$settings[$key];
        } else {
            return null;
        }
    }
}