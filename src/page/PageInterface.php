<?php

namespace Athens\Core\Page;

use Athens\Core\Writable\WritableInterface;
use Athens\Core\Initializer\InitializableInterface;
use Athens\Core\WritableBearer\WritableBearerBearerInterface;
use Athens\Core\Writer\HTMLWriter;
use Athens\Core\Initializer\Initializer;

interface PageInterface extends
    WritableInterface,
    WritableBearerBearerInterface,
    InitializableInterface,
    PageConstantsInterface
{

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @return string
     */
    public function getBaseHref();

    /**
     * @return string
     */
    public function getType();

    /**
     * @return mixed
     */
    public function render();
}
