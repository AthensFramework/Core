<?php

namespace Athens\Core\Renderer;

use Athens\Core\Writer\WriterInterface;
use Athens\Core\Visitor\VisitorInterface;
use Athens\Core\Visitor\VisitableInterface;

abstract class AbstractRenderer implements RendererInterface
{
    /** @var WriterInterface $writer */
    protected $writer;
    
    /** @var VisitorInterface */
    protected $initializer;

    public function __construct(VisitorInterface $initializer, WriterInterface $writer)
    {
        $this->writer = $writer;
        $this->initializer = $initializer;
    }
    
    public function visit(VisitableInterface $visitable)
    {
        $this->render($visitable);
    }
    
    abstract public function render($writable);
}