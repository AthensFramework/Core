<?php

namespace Athens\Core\Page;

use Athens\Core\Writable\WritableInterface;
use Athens\Core\Initializer\InitializableInterface;
use Athens\Core\Writer\Writer;
use Athens\Core\Initializer\Initializer;

interface PageInterface extends WritableInterface, InitializableInterface, PageConstantsInterface
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
     * @return WritableInterface
     */
    public function getWritable();

    /**
     * @param Initializer|null $initializer
     * @param Writer|null      $writer
     * @return mixed
     */
    public function render(Initializer $initializer, Writer $writer);
}
