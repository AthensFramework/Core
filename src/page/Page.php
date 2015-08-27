<?php

namespace UWDOEM\Framework\Page;


use UWDOEM\Framework\Writer\WritableInterface;


class Page implements PageInterface {

    const PAGE_TYPE_AJAX_ACTION = "ajax_action";
    const PAGE_TYPE_AJAX_PAGE = "ajax_page";
    const PAGE_TYPE_EXCEL = "excel";
    const PAGE_TYPE_FULL_HEADER = "full_header";
    const PAGE_TYPE_MINI_HEADER = "mini_header";
    const PAGE_TYPE_MULTI_PANEL = "multi_panel";
    const PAGE_TYPE_PDF = "pdf";

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
     * @param string $_baseHref
     * @param string $_header
     * @param string $_subHeader
     * @param string[] $_breadCrumbs
     * @param string[] $_returnTo
     * @param WritableInterface $_writable
     * @param string $_type
     */
    public function __construct($_baseHref, $_header, $_subHeader, array $_breadCrumbs, array $_returnTo, WritableInterface $_writable, $_type) {
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
}