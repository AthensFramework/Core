<?php

namespace Athens\Core\Section;

use Athens\Core\Writer\WritableInterface;
use Athens\Core\Initializer\InitializableInterface;

interface SectionInterface extends WritableInterface, InitializableInterface
{

    /**
     * @return string
     */
    public function getType();

    /**
     * @return SectionInterface[]
     */
    public function getWritables();
}
