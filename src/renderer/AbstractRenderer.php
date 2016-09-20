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
    /** @var WriterInterface[] $writer */
    protected $writers;

    /**
     * AbstractRenderer constructor.
     *
     * @param WriterInterface[] $writers
     */
    public function __construct(array $writers)
    {
        $this->writers = $writers;
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
     * @return string
     */
    protected function getContent(WritableInterface $writable)
    {
        foreach ($this->writers as $writer) {
            $content = $writable->accept($writer);

            if ($content !== null) {
                return $content;
            }
        }

        throw new \RuntimeException(
            "No visit method for " . get_class($writable) . " found among writers"
        );
    }

    /**
     * @param WritableInterface $writable
     * @return mixed
     */
    abstract public function render(WritableInterface $writable);
}
