<?php

namespace UWDOEM\Framework\Section;

use UWDOEM\Framework\Writer\WritableInterface;
use UWDOEM\Framework\Initializer\InitializableInterface;

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
