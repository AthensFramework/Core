<?php

namespace UWDOEM\Framework\Filter;

/**
 * Class FilterControls
 * @package UWDOEM\Framework\Filter
 */
class FilterControls
{

    /**
     * @param string $handle
     * @param string $key
     * @return boolean
     */
    public static function controlIsSet($handle, $key)
    {
        return array_key_exists("$handle-$key", $_GET);
    }

    /**
     * @param string $handle
     * @param string $key
     * @param string $default
     * @return string
     */
    public static function getControl($handle, $key, $default = "")
    {
        return static::controlIsSet($handle, $key) ? $_GET["$handle-$key"] : $default;
    }
}
