<?php

namespace Athens\Core\Renderer;

use Athens\Core\Writable\WritableInterface;

/**
 * Class HTMLRenderer
 * @package Athens\Core\Renderer
 */
class HTMLRenderer extends AbstractRenderer
{

    /**
     * @param WritableInterface $writable
     * @return void
     */
    public function render(WritableInterface $writable)
    {
        $content = $this->getContent($writable);

        echo $content;
    }
}
