<?php

namespace UWDOEM\Framework\Page;

use UWDOEM\Framework\Writer\WritableInterface;
use UWDOEM\Framework\Section\SectionBuilder;


class PageBuilder {

    /** @var string */
    protected $_baseHref;

    /** @var string */
    protected $_header;

    /** @var string */
    protected $_subHeader;

    /** @var string[] */
    protected $_breadCrumbs = [];

    /** @var string[] */
    protected $_returnTo = [];

    /** @var WritableInterface */
    protected $_writable;

    /** @var string */
    protected $_type;

    /** @var string */
    protected $_title;

    /** @var string[] */
    protected $_message;


    /**
     * @return PageBuilder
     */
    public static function begin() {
        return new static();
    }

    /**
     * @param string $type
     * @return PageBuilder
     */
    public function setType($type) {
        $this->_type = $type;
        return $this;
    }

    /**
     * @param string $title
     * @return PageBuilder
     */
    public function setTitle($title) {
        $this->_title = $title;
        return $this;
    }

    /**
     * @param string $baseHref
     * @return PageBuilder
     */
    public function setBaseHref($baseHref) {
        $this->_baseHref = $baseHref;
        return $this;
    }

    /**
     * @param string $header
     * @return PageBuilder
     */
    public function setHeader($header) {
        $this->_header = $header;
        return $this;
    }

    /**
     * @param string $subHeader
     * @return PageBuilder
     */
    public function setSubHeader($subHeader) {
        $this->_subHeader = $subHeader;
        return $this;
    }

    /**
     * @param string[] $breadCrumbs
     * @return PageBuilder
     */
    public function setBreadCrumbs($breadCrumbs) {
        $this->_breadCrumbs = $breadCrumbs;
        return $this;
    }

    /**
     * @param string[] $returnTo
     * @return PageBuilder
     */
    public function setReturnTo($returnTo) {
        $this->_returnTo = $returnTo;
        return $this;
    }

    /**
     * @param WritableInterface $writable
     * @return PageBuilder
     */
    public function setWritable($writable) {
        $this->_writable = $writable;
        return $this;
    }

    /**
     * @param string[] $message
     * @return PageBuilder
     */
    public function setMessage($message) {
        $this->_message = $message;
        return $this;
    }


    /**
     * @return PageInterface
     * @throws \Exception if the type of the page has not been set
     */
    public function build() {

        if (!isset($this->_type)) {
            throw new \Exception("You must set a page type using ::setType before calling this function.");
        }

        if (isset($this->_message)) {
            if ($this->_type !== Page::PAGE_TYPE_AJAX_ACTION) {
                throw new \Exception("You may only set a message on an ajax-action page.");
            }
        }

        if ($this->_type === Page::PAGE_TYPE_AJAX_ACTION ) {
            if (!isset($this->_message)) {
                throw new \Exception("You must provide a message for an ajax-action page using ::setMessage");
            }

            $this->_writable = SectionBuilder::begin()
                ->setId("ajax-action-" . $_SERVER["REQUEST_URI"])
                ->setContent(json_encode($this->_message))
                ->build();
        }

        return new Page(
            $this->_title,
            $this->_baseHref, 
            $this->_header, 
            $this->_subHeader, 
            $this->_breadCrumbs, 
            $this->_returnTo, 
            $this->_writable,
            $this->_type);
    }
}