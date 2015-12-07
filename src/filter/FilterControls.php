<?php

namespace UWDOEM\Framework\Filter;

class FilterControls
{

    public static function controlIsSet($handle, $key)
    {
        return array_key_exists("$handle-$key", $_GET);
    }

    public static function getControl($handle, $key, $default = null)
    {
        return static::controlIsSet($handle, $key) ? $_GET["$handle-$key"] : $default;
    }
}
