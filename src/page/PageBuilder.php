<?php

namespace UWDOEM\Framework\Page;

use UWDOEM\Framework\Writer\WritableInterface;
use UWDOEM\Framework\Section\SectionBuilder;

class PageBuilder
{

    /** @var string */
    protected $baseHref;

    /** @var string */
    protected $header;

    /** @var string */
    protected $subHeader;

    /** @var string[] */
    protected $breadCrumbs = [];

    /** @var string[] */
    protected $returnTo = [];

    /** @var WritableInterface */
    protected $writable;

    /** @var string */
    protected $type;

    /** @var string */
    protected $title;

    /** @var string[] */
    protected $message;


    /**
     * @return PageBuilder
     */
    public static function begin()
    {
        return new static();
    }

    /**
     * @param string $type
     * @return PageBuilder
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @param string $title
     * @return PageBuilder
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param string $baseHref
     * @return PageBuilder
     */
    public function setBaseHref($baseHref)
    {
        $this->baseHref = $baseHref;
        return $this;
    }

    /**
     * @param string $header
     * @return PageBuilder
     */
    public function setHeader($header)
    {
        $this->header = $header;
        return $this;
    }

    /**
     * @param string $subHeader
     * @return PageBuilder
     */
    public function setSubHeader($subHeader)
    {
        $this->subHeader = $subHeader;
        return $this;
    }

    /**
     * @param string[] $breadCrumbs
     * @return PageBuilder
     */
    public function setBreadCrumbs($breadCrumbs)
    {
        $this->breadCrumbs = $breadCrumbs;
        return $this;
    }

    /**
     * @param string[] $returnTo
     * @return PageBuilder
     */
    public function setReturnTo($returnTo)
    {
        $this->returnTo = $returnTo;
        return $this;
    }

    /**
     * @param WritableInterface $writable
     * @return PageBuilder
     */
    public function setWritable($writable)
    {
        $this->writable = $writable;
        return $this;
    }

    /**
     * @param string[] $message
     * @return PageBuilder
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }


    /**
     * @return PageInterface
     * @throws \Exception if the type of the page has not been set
     */
    public function build()
    {

        if (!isset($this->type)) {
            throw new \Exception("You must set a page type using ::setType before calling this function.");
        }

        if (isset($this->message)) {
            if ($this->type !== Page::PAGE_TYPE_AJAX_ACTION) {
                throw new \Exception("You may only set a message on an ajax-action page.");
            }
        }

        if ($this->type === Page::PAGE_TYPE_AJAX_ACTION) {
            if (!isset($this->message)) {
                throw new \Exception("You must provide a message for an ajax-action page using ::setMessage");
            }

            $this->writable = SectionBuilder::begin()
                ->setId("ajax-action-" . $_SERVER["REQUEST_URI"])
                ->setContent(json_encode($this->message))
                ->build();
        }

        return new Page(
            $this->type,
            $this->title,
            $this->baseHref,
            $this->header,
            $this->subHeader,
            $this->breadCrumbs,
            $this->returnTo,
            $this->writable
        );
    }
}
