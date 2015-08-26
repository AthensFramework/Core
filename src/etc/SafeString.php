<?php

namespace UWDOEM\Framework\Etc;

/**
 * Class SafeString Wrapper class for strings that marks them as safe for printing to any display
 * @package UWDOEM\Framework\Etc
 */
class SafeString {

    protected $_value;

    protected function __construct($value) {
        $this->_value = $value;
    }

    public function __toString() {
        return $this->_value;
    }

    /**
     * Create a SafeString from a string
     *
     * @param string $value
     * @return SafeString
     */
    public static function fromString($value) {
        $safeString = new self($value);
        return $safeString;
    }

}