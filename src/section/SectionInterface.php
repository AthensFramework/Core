<?php

namespace Athens\Core\Section;

use Athens\Core\Writer\WritableInterface;
use Athens\Core\Initializer\InitializableInterface;

interface SectionInterface extends WritableInterface, InitializableInterface, SectionConstantsInterface
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
