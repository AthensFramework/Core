<?php

namespace UWDOEM\Framework\Page;

use DOMPDF;

use UWDOEM\Framework\Writer\WritableInterface;
use UWDOEM\Framework\Visitor\VisitableTrait;
use UWDOEM\Framework\Writer\Writer;
use UWDOEM\Framework\Etc\Settings;
use UWDOEM\Framework\Initializer\Initializer;

class Page implements PageInterface
{

    const PAGE_TYPE_AJAX_ACTION = "ajax-action";
    const PAGE_TYPE_AJAX_PAGE = "ajax-page";
    const PAGE_TYPE_EXCEL = "excel";
    const PAGE_TYPE_FULL_HEADER = "full-header";
    const PAGE_TYPE_MINI_HEADER = "mini-header";
    const PAGE_TYPE_MULTI_PANEL = "multi-panel";
    const PAGE_TYPE_PDF = "pdf";
    const PAGE_TYPE_MARKDOWN_DOCUMENTATION = "markdown-documentation";

    use VisitableTrait;

    /** @var string */
    protected $title;

    /** @var string */
    protected $baseHref;

    /** @var string */
    protected $header;
    
    /** @var string */
    protected $subHeader;

    /** @var string[] */
    protected $breadCrumbs;
    
    /** @var string[] */
    protected $returnTo;

    /** @var WritableInterface */
    protected $writable;

    /** @var string */
    protected $type;


    public function getId()
    {
        return md5($_SERVER['REQUEST_URI']);
    }

    /**
     * Page constructor.
     * @param string $type
     * @param string $title
     * @param string $baseHref
     * @param string $header
     * @param string $subHeader
     * @param string[] $breadCrumbs
     * @param string[] $returnTo
     * @param WritableInterface|null $writable
     */
    public function __construct(
        $type,
        $title,
        $baseHref,
        $header,
        $subHeader,
        array $breadCrumbs,
        array $returnTo,
        WritableInterface $writable = null
    ) {
        $this->title = $title;
        $this->baseHref = $baseHref;
        $this->header = $header;
        $this->subHeader = $subHeader;
        $this->breadCrumbs = $breadCrumbs;
        $this->returnTo = $returnTo;
        $this->writable = $writable;
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getBaseHref()
    {
        return $this->baseHref;
    }

    /**
     * @return string
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * @return string
     */
    public function getSubHeader()
    {
        return $this->subHeader;
    }

    /**
     * @return string[]
     */
    public function getBreadCrumbs()
    {
        return $this->breadCrumbs;
    }

    /**
     * @return string[]
     */
    public function getReturnTo()
    {
        return $this->returnTo;
    }

    /**
     * @return WritableInterface|null
     */
    public function getWritable()
    {
        return $this->writable;
    }

    protected function makeDefaultInitializer()
    {
        $initializerClass = Settings::getDefaultInitializerClass();
        return new $initializerClass();
    }

    protected function makeDefaultWriter()
    {
        $writerClass = Settings::getDefaultWriterClass();
        return new $writerClass();
    }

    protected function makeDefaultRendererFunction()
    {

        if ($this->getType() === static::PAGE_TYPE_PDF) {
            $documentName = $this->getTitle() ? $this->getTitle() : "document";
            $renderFunction = function ($content) use ($documentName) {
                $dompdf = new DOMPDF();
                $dompdf->load_html($content);
                $dompdf->render();
                $dompdf->stream($documentName . ".pdf");
            };
        } else {
            $renderFunction = function ($content) {
                echo $content;
            };
        }

        return $renderFunction;
    }

    /**
     * @param Initializer|null $initializer
     * @param Writer|null $writer
     * @param callable|null $renderFunction
     * @return null
     */
    public function render(
        Initializer $initializer = null,
        Writer $writer = null,
        callable $renderFunction = null
    ) {

        if (is_null($initializer)) {
            $initializer = $this->makeDefaultInitializer();
        }
        
        if (is_null($writer)) {
            $writer = $this->makeDefaultWriter();
        }

        if (is_null($renderFunction)) {
            $renderFunction = $this->makeDefaultRendererFunction();
        }

        $this->accept($initializer);
        $renderFunction($this->accept($writer));
    }
}
