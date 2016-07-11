<?php

namespace Athens\Core\Renderer;

use Athens\Core\Writer\WriterInterface;
use Athens\Core\Writable\WritableInterface;

interface RendererInterface
{
    public function __construct(WriterInterface $writer);

    /**
     * @param WritableInterface $writable
     * @return void
     */
    public function render($writable);
}