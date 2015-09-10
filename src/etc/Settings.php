<?php

namespace UWDOEM\Framework\Etc;


class Settings {

    protected static $settings = [
        "templateDirectories" => [],
        "projectJS" => [],
        "projectCSS" => [],
        "defaultWriterClass" => '\UWDOEM\Writer\Writer'
    ];

    protected function __construct() {}

    public static function addTemplateTheme($theme) {
        $templateDirectory = dirname(__FILE__) . '/../writer/templates/' . $theme;
        static::addTemplateDirectory($templateDirectory);
    }

    public static function addTemplateDirectory($directory) {
        static::$settings["templateDirectories"][] = $directory;
    }

    public static function addProjectCSS($file) {
        static::$settings["projectCSS"][] = $file;
    }

    public static function addProjectJS($file) {
        static::$settings["projectJS"][] = $file;
    }

    public static function getTemplateDirectories() {
        return static::getSetting("templateDirectories");
    }

    public static function setDefaultWriterClass($writerClass) {
        static::$settings["defaultWriterClass"] = $writerClass;
    }

    public static function getDefaultWriterClass() {
        return static::getSetting("defaultWriterClass");
    }

    public static function getProjectJS() {
        return static::getSetting("projectJS");
    }

    public static function getProjectCSS() {
        return static::getSetting("projectCSS");
    }

    protected static function getSetting($key) {
        if (array_key_exists($key, static::$settings)) {
            return static::$settings[$key];
        } else {
            return null;
        }
    }
}