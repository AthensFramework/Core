<?php

namespace UWDOEM\Framework\Field;

use DateTime;

class DateTimeWrapper extends DateTime
{
    public function __toString()
    {
        return $this->format('Y-m-d');
    }
}
