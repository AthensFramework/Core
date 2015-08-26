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
        $search = array('À','Á','Â','Ã','Ä','Å','Æ','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ð','Ñ','Ò','Ó','Ô','Õ','Ö','Ø','Ù','Ú','Û','Ü','Ý','ß','à','á','â','ã','ä','å','æ','ç','è','é','ê','ë','ì','í','î','ï','ñ','ò','ó','ô','õ','ö','ø','ù','ú','û','ü','ý','ÿ','A','a','A','a','A','a','C','c','C','c','C','c','C','c','D','d','Ð','d','E','e','E','e','E','e','E','e','E','e','G','g','G','g','G','g','G','g','H','h','H','h','I','i','I','i','I','i','I','i','I','i','?','?','J','j','K','k','L','l','L','l','L','l','?','?','L','l','N','n','N','n','N','n','?','O','o','O','o','O','o','Œ','œ','R','r','R','r','R','r','S','s','S','s','S','s','Š','š','T','t','T','t','T','t','U','u','U','u','U','u','U','u','U','u','U','u','W','w','Y','y','Ÿ','Z','z','Z','z','Ž','ž','?','ƒ','O','o','U','u','A','a','I','i','O','o','U','u','U','u','U','u','U','u','U','u','?','?','?','?','?','?');
        $replace = array('A','A','A','A','A','A','AE','C','E','E','E','E','I','I','I','I','D','N','O','O','O','O','O','O','U','U','U','U','Y','s','a','a','a','a','a','a','ae','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','o','u','u','u','u','y','y','A','a','A','a','A','a','C','c','C','c','C','c','C','c','D','d','D','d','E','e','E','e','E','e','E','e','E','e','G','g','G','g','G','g','G','g','H','h','H','h','I','i','I','i','I','i','I','i','I','i','IJ','ij','J','j','K','k','L','l','L','l','L','l','L','l','l','l','N','n','N','n','N','n','n','O','o','O','o','O','o','OE','oe','R','r','R','r','R','r','S','s','S','s','S','s','S','s','T','t','T','t','T','t','U','u','U','u','U','u','U','u','U','u','U','u','W','w','Y','y','Y','Z','z','Z','z','Z','z','s','f','O','o','U','u','A','a','I','i','O','o','U','u','U','u','U','u','U','u','U','u','A','a','AE','ae','O','o');
        $string = strtolower(preg_replace(array('/[^a-zA-Z0-9 -]/','/[ -]+/','/^-|-$/'),array('','-',''),str_replace($search,$replace,$string)));

        // Trim numbers from the left side of the string
        $string = ltrim($string, "0123456789");

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