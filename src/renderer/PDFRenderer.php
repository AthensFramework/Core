<?php

namespace Athens\Core\Renderer;

use Athens\Core\Writable\WritableInterface;

/**
 * Class PDFRenderer
 *
 * @package Athens\Core\Renderer
 */
class PDFRenderer extends AbstractRenderer
{

    /**
     * @param WritableInterface $writable
     * @return void
     */
    public function render(WritableInterface $writable)
    {
        $writable->accept($this->initializer);

        $documentName = $writable->getTitle() ? $writable->getTitle() : "document";
        $content = $writable->accept($this->writer);

        $dompdf = new DOMPDF();
        $dompdf->load_html($content);
        $dompdf->render();
        $dompdf->stream($documentName . ".pdf");
    }
}
