<?php

namespace UWDOEM\Framework\Field;

use DateTime;

/**
 * Class DateTimeWrapper provides a default string representation for DateTime
 *
 * @package UWDOEM\Framework\Field
 */
class DateTimeWrapper extends DateTime
{

    /**
     * Provides a default string representation for this datetime.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->format('Y-m-d');
    }
}
