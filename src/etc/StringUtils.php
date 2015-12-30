<?php

namespace UWDOEM\Framework\Etc;

/**
 * Class StringUtils is a static class to provide string manipulation utilities
 *
 * @package UWDOEM\Framework\Etc
 */
class StringUtils
{

    /**
     * Disallow class instantiation
     */
    private function __construct()
    {
    }

    /**
     * Turn a string into a slug
     *
     * @param string $string
     * @return string
     */
    public static function slugify($string)
    {
        // Replace non-alpha-numerics with dashes
        $string = strtolower(preg_replace(array('/[^a-zA-Z0-9 -]/','/[ -]+/','/^-|-$/'), array('','-',''), $string));

        // Trim dashes from the left side of the string
        $string = ltrim($string, "-");

        // Trim dashes from the right side of the string
        $string = rtrim($string, '-');

        return $string;
    }

    /**
     * Format a string into title case
     *
     * @param string $string
     * @return string
     */
    public static function toTitleCase($string)
    {

        // Replace underscores, dashes with spaces
        $string = str_replace(["_", "-"], " ", $string);

        // Break the string into an array of words
        $name_array = explode(" ", $string);

        // Words not-to capitalize
        $smallWords = [
            'of','a','the','and','an','or','nor','but','is','if','then','else','when',
            'at','from','by','on','off','for','in','out','over','to','into','with'
        ];

        $acronyms = Settings::getAcronyms();

        foreach ($name_array as $index => $value) {
            if (in_array($value, $acronyms) === true) {
                $name_array[$index] = strtoupper($value);
            } elseif ($index === 0 || $index === sizeof($name_array) - 1) {
                $name_array[$index] = ucfirst($value);
            } elseif (in_array($value, $smallWords) === true) {
                // do nothing
            } else {
                $name_array[$index] = ucfirst($value);
            }
        }

        // Recombine the array into a single string, and convert to capital case
        $string = implode(" ", $name_array);

        return $string;
    }

    /**
     * Format a string into upper camel case
     *
     * @param string $string
     * @return string
     */
    public static function toUpperCamelCase($string)
    {
        return str_replace(" ", "", ucwords(str_replace(["_", ".", "-"], " ", $string)));
    }

    /**
     * Format a number as dollars, with grouped thousands.
     *
     * @param mixed $number
     * @return string
     */
    public static function formatDollars($number)
    {
        return '$' . number_format($number, 2);
    }
}
