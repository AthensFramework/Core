<?php

namespace Athens\Core\Renderer;

use Athens\Core\Writable\WritableInterface;
use Dompdf\Dompdf;

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
        $dompdf->loadHtml($content);
        $dompdf->render();
        $dompdf->stream($documentName . ".pdf");
    }
}
