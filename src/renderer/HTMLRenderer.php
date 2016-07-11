<?php

namespace Athens\Core\Renderer;

class HTMLRenderer extends AbstractRenderer
{
    public function render($writable)
    {
        $content = $writable->accept($this->writer);

        echo $content;
    }
}