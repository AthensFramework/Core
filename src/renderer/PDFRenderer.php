<?php

namespace Athens\Core\Renderer;

class PDFRenderer extends AbstractRenderer
{
    public function render($writable)
    {
        $writable->accept($this->initializer);

        $documentName = $writable->getTitle() ? $writable->getTitle() : "document";
        $content = $writable->accept($writer);

        $dompdf = new DOMPDF();
        $dompdf->load_html($content);
        $dompdf->render();
        $dompdf->stream($documentName . ".pdf");
    }
}