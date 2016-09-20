<?php

namespace Athens\Core\Etc;

/**
 * Class ArrayUtils is a static class to provide array manipulation utilities
 *
 * @package Athens\Core\Etc
 */
class ArrayUtils
{

    /**
     * Disallow class instantiation
     */
    protected function __construct()
    {
    }

    /**
     * Find the element of the given array with the given key, or return the
     * default if unfound.
     *
     * @param string|integer $needle
     * @param array          $haystack
     * @param mixed          $default
     * @return mixed
     */
    public static function findOrDefault($needle, array $haystack, $default)
    {
        return array_key_exists($needle, $haystack) === true ? $haystack[$needle] : $default;
    }
}
