<?php

namespace UWDOEM\Framework\Etc;

/**
 * Class StringUtils Static class to provide some string manipulation utilities
 * @package UWDOEM\Framework\Etc
 */
class StringUtils {

    // Disallow class instantiation
    private function __construct() {}

    /**
     * Turn a string into a slug
     *
     * @param string $string
     * @return string
     */
    static function slugify($string) {
        // Transliterate the string into ASCII
        $string = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $string);

        // Replace non-alpha-numerics with dashes
        $string = strtolower(preg_replace(array('/[^a-zA-Z0-9 -]/','/[ -]+/','/^-|-$/'),array('','-',''), $string));

        // Trim numbers and dashes from the left side of the string
        $string = ltrim($string, "0123456789-");

        // Trim dashes from the right side oft he string
        $string = rtrim($string, '-');

        return $string;
    }

    /**
     * Format a string into title case
     *
     * @param string $string
     * @return string
     */
    static function toTitleCase($string) {

        // Replace underscores, dashes with spaces
        $string = str_replace(["_", "-"], " ", $string);

        // Break the string into an array of words
        $name_array = explode(" ", $string);

        // Words not-to capitalize
        $smallWords = array(
            'of','a','the','and','an','or','nor','but','is','if','then','else','when',
            'at','from','by','on','off','for','in','out','over','to','into','with'
        );

        foreach ($name_array as $index => $value) {
            if (!in_array($value, $smallWords) || $index == 0) {
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
    static function toUpperCamelCase($string) {
        return str_replace(" ", "", ucwords(str_replace(["_", ".", "-"], " ", $string)));
    }
}