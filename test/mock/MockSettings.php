<?php

namespace UWDOEM\Framework\Test\Mock;

use UWDOEM\Framework\Etc\Settings;

class MockSettings extends Settings
{

    public static function clear()
    {
        static::$settings["templateDirectories"] = [];
        static::$settings["projectCSS"] = [];
        static::$settings["projectJS"] = [];
        static::$settings["defaultPagination"] = 12;
    }
}
