<?php

namespace Athens\Core\Writer;

use Athens\Core\Visitor\Visitor;
use Athens\Core\Writable\WritableInterface;

/**
 * Class AbstractWriter
 *
 * @package Athens\Core\Writer
 */
abstract class AbstractWriter implements WriterInterface
{

    /**
     * Visit a writable host and render it into html.
     *
     * @param WritableInterface $host
     * @return string
     */
    protected function write(WritableInterface $host)
    {
        return $host->accept($this);
    }
}
