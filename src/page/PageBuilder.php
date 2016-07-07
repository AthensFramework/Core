<?php

namespace Athens\Core\Page;

use Athens\Core\Etc\AbstractBuilder;
use Athens\Core\Writer\WritableInterface;
use Athens\Core\Section\SectionBuilder;
use Athens\Core\Etc\SafeString;
use Athens\Core\WritableBearer\WritableBearerBearerBuilderTrait;

/**
 * Class PageBuilder
 *
 * @package Athens\Core\Page
 */
class PageBuilder extends AbstractBuilder implements PageConstantsInterface
{

    /** @var string */
    protected $baseHref;

    /** @var string */
    protected $header;

    /** @var string */
    protected $subHeader;

    /** @var string[] */
    protected $breadCrumbTitles = [];

    /** @var string[] */
    protected $breadCrumbLinks = [];

    /** @var string */
    protected $type;

    /** @var string */
    protected $title;

    use WritableBearerBearerBuilderTrait;

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
     * @param string $title
     * @param string $link
     * @return PageBuilder
     */
    public function addBreadCrumb($title, $link = "")
    {
        $this->breadCrumbTitles[] = $title;
        $this->breadCrumbLinks[] = $link;
        
        return $this;
    }

    /**
     * @return PageInterface
     * @throws \Exception If the type of the page has not been set.
     */
    public function build()
    {
        if ($this->type === null) {
            throw new \Exception("You must set a page type using ::setType before calling this function.");
        }

        $writable = $this->buildWritableBearer();

        return new Page($this->id, $this->type, $this->classes, $this->data, $this->title, $this->baseHref, $writable);
    }
}
