<?php

namespace Athens\Core\Choice;

use Athens\Core\Writer\WritableInterface;

interface ChoiceInterface extends WritableInterface
{

    /** @return string */
    public function getKey();

    /** @return string */
    public function getValue();

}
