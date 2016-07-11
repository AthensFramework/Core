<?php

namespace Athens\Core\Renderer;

use Athens\Core\Visitor\VisitorInterface;
use Athens\Core\Writer\WriterInterface;
use Athens\Core\Writable\WritableInterface;

interface RendererInterface extends VisitorInterface
{
    /**
     * @param WritableInterface $writable
     * @return void
     */
    public function render($writable);
}