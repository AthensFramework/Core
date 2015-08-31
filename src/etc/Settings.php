<?php

namespace UWDOEM\Framework\Etc;


class Settings {

    protected static $settings = [];

    protected function __construct() {}

    /**
     * @param string $theme
     */
    public static function addTemplateTheme($theme) {
        if (array_key_exists("themes", static::$settings)) {
            static::$settings["themes"][] = $theme;
        } else {
            static::$settings["themes"] = [$theme];
        }
    }

    public static function getTemplateThemes() {
        if (array_key_exists("themes", static::$settings)) {
            return static::$settings["themes"];
        } else {
            return [];
        }
    }
}