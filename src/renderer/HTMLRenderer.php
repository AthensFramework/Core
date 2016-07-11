<?php

namespace Athens\Core\Renderer;

class HTMLRenderer extends AbstractRenderer
{
    public function render($writable)
    {
        $writable->accept($this->initializer);
        $content = $writable->accept($this->writer);

        echo $content;
    }
}