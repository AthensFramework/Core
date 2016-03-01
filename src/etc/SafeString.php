<?php

namespace Athens\Core\Etc;

/**
 * Class SafeString is a wrapper class for strings that marks them
 * as safe for printing to any display.
 *
 * @package Athens\Core\Etc
 */
class SafeString
{

    /** @var string */
    protected $value;

    /**
     * @param string $value
     */
    protected function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
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
