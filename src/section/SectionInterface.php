<?php

namespace Athens\Core\Section;

use Athens\Core\Writable\WritableInterface;
use Athens\Core\Initializer\InitializableInterface;
use Athens\Core\WritableBearer\WritableBearerBearerInterface;

interface SectionInterface extends
    WritableInterface,
    WritableBearerBearerInterface,
    InitializableInterface,
    SectionConstantsInterface
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
