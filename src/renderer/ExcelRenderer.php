<?php

namespace Athens\Core\Renderer;

class ExcelRenderer extends AbstractRenderer
{
    public function render($writable)
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