<?php

namespace Athens\Core\Renderer;

use Athens\Core\Writer\WriterInterface;

abstract class AbstractRenderer implements RendererInterface
{
    /** @var WriterInterface $writer */
    protected $writer;
    
    public function __construct(WriterInterface $writer)
    {
        $this->writer = $writer;
    }
    
    abstract public function render($writable);
}