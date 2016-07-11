<?php

namespace Athens\Core\Etc;

/**
 * Class Settings is a static class for maintaining application-wide settings.
 * @package Athens\Core\Etc
 */
class Settings
{
    /** @var array */
    protected static $settings = [
        "templateDirectories" => [],
        "projectJS" => [],
        "projectCSS" => [],
        "acronyms" => [],
        "defaultWriterClass" => '\Athens\Core\Writer\HTMLWriter',
        "defaultEmailerClass" => '\Athens\Core\Emailer\PhpEmailer',
        "defaultInitializerClass" => '\Athens\Core\Initializer\Initializer',
        "defaultPagination" => 12
    ];

    /**
     * Disallow class instantiation.
     */
    protected function __construct()
    {
    }

    /**
     * @param string $theme
     * @return void
     */
    public static function addTemplateTheme($theme)
    {
        $templateDirectory = dirname(__FILE__) . '/../../templates/' . $theme;
        static::addTemplateDirectory($templateDirectory);
    }

    /**
     * @param string $directory
     * @return void
     */
    public static function addTemplateDirectory($directory)
    {
        static::$settings["templateDirectories"][] = $directory;
    }

    /**
     * @param string $file
     * @return void
     */
    public static function addProjectCSS($file)
    {
        static::$settings["projectCSS"][] = $file;
    }

    /**
     * @param string $file
     * @return void
     */
    public static function addProjectJS($file)
    {
        static::$settings["projectJS"][] = $file;
    }

    /**
     * @return string[]
     */
    public static function getTemplateDirectories()
    {
        return static::getSetting("templateDirectories");
    }

    /**
     * @param string $writerClass
     * @return void
     */
    public static function setDefaultWriterClass($writerClass)
    {
        static::$settings["defaultWriterClass"] = $writerClass;
    }

    /**
     * @return string
     */
    public static function getDefaultWriterClass()
    {
        return static::getSetting("defaultWriterClass");
    }

    /**
     * @param string $emailerClass
     * @return void
     */
    public static function setDefaultEmailerClass($emailerClass)
    {
        static::$settings["defaultEmailerClass"] = $emailerClass;
    }

    /**
     * @return string
     */
    public static function getDefaultEmailerClass()
    {
        return static::getSetting("defaultEmailerClass");
    }

    /**
     * @param string $initializerClass
     * @return void
     */
    public static function setDefaultInitializerClass($initializerClass)
    {
        static::$settings["defaultInitializerClass"] = $initializerClass;
    }

    /**
     * @return string
     */
    public static function getDefaultInitializerClass()
    {
        return static::getSetting("defaultInitializerClass");
    }

    /**
     * @return string[]
     */
    public static function getProjectJS()
    {
        return static::getSetting("projectJS");
    }

    /**
     * @return string[]
     */
    public static function getProjectCSS()
    {
        return static::getSetting("projectCSS");
    }

    /**
     * @return integer
     */
    public static function getDefaultPagination()
    {
        return static::getSetting("defaultPagination");
    }

    /**
     * @param string[] $acronyms
     * @return void
     */
    public static function setAcronyms(array $acronyms)
    {
        static::$settings["acronyms"] = $acronyms;
    }

    /**
     * @return string[]
     */
    public static function getAcronyms()
    {
        return static::getSetting("acronyms");
    }

    /**
     * @param integer $value The default number of rows per page to display, when paginating.
     * @return void
     */
    public static function setDefaultPagination($value)
    {
        static::$settings["defaultPagination"] = $value;
    }

    /**
     * @param string $key
     * @return null|mixed
     */
    protected static function getSetting($key)
    {
        if (array_key_exists($key, static::$settings) === true) {
            return static::$settings[$key];
        } else {
            return null;
        }
    }
}
