<?php

namespace UWDOEM\Framework\Etc;

/**
 * Class Settings is a static class for maintaining application-wide settings.
 * @package UWDOEM\Framework\Etc
 */
class Settings {

    protected static $settings = [
        "templateDirectories" => [],
        "projectJS" => [],
        "projectCSS" => [],
        "defaultWriterClass" => '\UWDOEM\Framework\Writer\Writer',
        "defaultInitializerClass" => '\UWDOEM\Framework\Initializer\Initializer',
        "defaultPagination" => 12
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

    public static function setDefaultInitializerClass($initializerClass) {
        static::$settings["defaultInitializerClass"] = $initializerClass;
    }

    public static function getDefaultInitializerClass() {
        return static::getSetting("defaultInitializerClass");
    }

    public static function getProjectJS() {
        return static::getSetting("projectJS");
    }

    public static function getProjectCSS() {
        return static::getSetting("projectCSS");
    }

    public static function getDefaultPagination() {
        return static::getSetting("defaultPagination");
    }

    /**
     * @param int $value The default number of rows per page to display, when paginating
     */
    public static function setDefaultPagination($value) {
        static::$settings["defaultPagination"] = $value;
    }

    protected static function getSetting($key) {
        if (array_key_exists($key, static::$settings)) {
            return static::$settings[$key];
        } else {
            return null;
        }
    }
}