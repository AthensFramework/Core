<?php

namespace Athens\Core\Renderer;

use Athens\Core\Writable\WritableInterface;
use DOMPDF;

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
        $documentName = $writable->getTitle() === true ? $writable->getTitle() : "document";

        $content = $this->getContent($writable);

        $dompdf = new DOMPDF();
        $dompdf->load_html($content);
        $dompdf->render();
        $dompdf->stream($documentName . ".pdf");
    }
}
