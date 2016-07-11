<?php

namespace Athens\Core\Test\Mock;

use Athens\Core\Settings\Settings;

class MockSettings extends Settings
{
    
    /** @var  MockSettings */
    protected static $mockInstance;

    public function clear()
    {
        static::$settings["templateDirectories"] = [];
        static::$settings["projectCSS"] = [];
        static::$settings["projectJS"] = [];
        static::$settings["defaultPagination"] = 12;
    }

    public static function getInstance()
    {
        if (static::$mockInstance === null) {
            static::$mockInstance = new static();
        }

        return static::$mockInstance;
    }
}
