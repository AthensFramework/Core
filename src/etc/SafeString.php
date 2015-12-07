<?php

namespace UWDOEM\Framework\Etc;

/**
 * Class SafeString is a wrapper class for strings that marks them
 * as safe for printing to any display.
 *
 * @package UWDOEM\Framework\Etc
 */
class SafeString
{

    /** @var string */
    protected $value;

    protected function __construct($value)
    {
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }

    /**
     * Create a SafeString from a string
     *
     * @param string $value
     * @return SafeString
     */
    public static function fromString($value)
    {
        $safeString = new self($value);
        return $safeString;
    }
}
