<?php

namespace Athens\Core\Test\Mock;

use Athens\Core\Etc\Settings;

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
