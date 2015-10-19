<?php

namespace UWDOEM\Framework\Page;

use UWDOEM\Framework\Writer\WritableInterface;
use UWDOEM\Framework\Visitor\VisitableTrait;
use UWDOEM\Framework\Writer\Writer;
use UWDOEM\Framework\Etc\Settings;
use UWDOEM\Framework\Initializer\Initializer;


class Page implements PageInterface {

    const PAGE_TYPE_AJAX_ACTION = "ajax-action";
    const PAGE_TYPE_AJAX_PAGE = "ajax-page";
    const PAGE_TYPE_EXCEL = "excel";
    const PAGE_TYPE_FULL_HEADER = "full-header";
    const PAGE_TYPE_MINI_HEADER = "mini-header";
    const PAGE_TYPE_MULTI_PANEL = "multi-panel";
    const PAGE_TYPE_PDF = "pdf";

    use VisitableTrait;

    /** @var string */
    protected $_title;

    /** @var string */
    protected $_baseHref;

    /** @var string */
    protected $_header;
    
    /** @var string */
    protected $_subHeader;

    /** @var string[] */
    protected $_breadCrumbs;
    
    /** @var string[] */
    protected $_returnTo;

    /** @var WritableInterface */
    protected $_writable;

    /** @var string */
    protected $_type;


    /**
     * Page constructor.
     * @param string $_title
     * @param string $_baseHref
     * @param string $_header
     * @param string $_subHeader
     * @param string[] $_breadCrumbs
     * @param string[] $_returnTo
     * @param WritableInterface $_writable
     * @param string $_type
     */
    public function __construct($_title, $_baseHref, $_header, $_subHeader, array $_breadCrumbs, array $_returnTo, WritableInterface $_writable, $_type) {
        $this->_title = $_title;
        $this->_baseHref = $_baseHref;
        $this->_header = $_header;
        $this->_subHeader = $_subHeader;
        $this->_breadCrumbs = $_breadCrumbs;
        $this->_returnTo = $_returnTo;
        $this->_writable = $_writable;
        $this->_type = $_type;
    }

    /**
     * @return string
     */
    public function getType() {
        return $this->_type;
    }

    /**
     * @return string
     */
    public function getTitle() {
        return $this->_title;
    }

    /**
     * @return string
     */
    public function getBaseHref() {
        return $this->_baseHref;
    }

    /**
     * @return string
     */
    public function getHeader() {
        return $this->_header;
    }

    /**
     * @return string
     */
    public function getSubHeader() {
        return $this->_subHeader;
    }

    /**
     * @return string[]
     */
    public function getBreadCrumbs() {
        return $this->_breadCrumbs;
    }

    /**
     * @return string[]
     */
    public function getReturnTo() {
        return $this->_returnTo;
    }

    /**
     * @return WritableInterface
     */
    public function getWritable() {
        return $this->_writable;
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
            $initializerClass = Settings::getDefaultInitializerClass();
            $initializer = new $initializerClass();
        }
        $this->accept($initializer);
        
        if (is_null($writer)) {
            $writerClass = Settings::getDefaultWriterClass();
            $writer = new $writerClass();
        }

        if (is_null($renderFunction)) {
            $renderFunction = function($content) {
                echo $content;
            };
        }

        $renderFunction($this->accept($writer));
    }
}