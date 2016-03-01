<?php

namespace Athens\Core\Field;

use DateTime;

/**
 * Class DateTimeWrapper provides a default string representation for DateTime
 *
 * @package Athens\Core\Field
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
