<?php

namespace Athens\Core\Renderer;

use Athens\Core\Writable\WritableInterface;

/**
 * Class ExcelRenderer
 *
 * @package Athens\Core\Renderer
 */
class ExcelRenderer extends AbstractRenderer
{

    /**
     * @param WritableInterface $writable
     * @return void
     */
    public function render(WritableInterface $writable)
    {
        $writable->accept($this->initializer);
        $content = $writable->accept($this->writer);

        $filename = "title";
        $filename = date("Y-m-d-") . "$filename.xlsx";

        header("Content-Disposition: attachment; filename=$filename;");
        header("Content-Type: application/octet-stream");

        echo $content;
    }
}
