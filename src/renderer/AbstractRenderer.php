<?php

namespace Athens\Core\Renderer;

use Athens\Core\Writer\WriterInterface;
use Athens\Core\Visitor\VisitorInterface;
use Athens\Core\Visitor\VisitableInterface;
use Athens\Core\Writable\WritableInterface;

/**
 * Class AbstractRenderer
 * @package Athens\Core\Renderer
 */
abstract class AbstractRenderer implements RendererInterface
{
    /** @var WriterInterface $writer */
    protected $writer;
    
    /** @var VisitorInterface */
    protected $initializer;

    /**
     * AbstractRenderer constructor.
     *
     * @param VisitorInterface $initializer
     * @param WriterInterface  $writer
     */
    public function __construct(VisitorInterface $initializer, WriterInterface $writer)
    {
        $this->writer = $writer;
        $this->initializer = $initializer;
    }

    /**
     * @param VisitableInterface $visitable
     * @return void
     */
    public function visit(VisitableInterface $visitable)
    {
        $this->render($visitable);
    }

    /**
     * @param WritableInterface $writable
     * @return mixed
     */
    abstract public function render(WritableInterface $writable);
}
