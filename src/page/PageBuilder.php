<?php

namespace Athens\Core\Page;

use Athens\Core\Etc\AbstractBuilder;
use Athens\Core\Writer\WritableInterface;
use Athens\Core\Section\SectionBuilder;
use Athens\Core\Etc\SafeString;
use Propel\Runtime\ActiveQuery\ModelCriteria;

/**
 * Class PageBuilder
 *
 * @package Athens\Core\Page
 */
class PageBuilder extends AbstractBuilder
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

    /** @var ModelCriteria */
    protected $objectManagerQuery;

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
    public function setBreadCrumbs(array $breadCrumbs)
    {
        $this->breadCrumbs = $breadCrumbs;
        return $this;
    }

    /**
     * @param string[] $returnTo
     * @return PageBuilder
     */
    public function setReturnTo(array $returnTo)
    {
        $this->returnTo = $returnTo;
        return $this;
    }

    /**
     * @param WritableInterface $writable
     * @return PageBuilder
     */
    public function setWritable(WritableInterface $writable)
    {
        $this->writable = $writable;
        return $this;
    }

    /**
     * @param string[] $message
     * @return PageBuilder
     */
    public function setMessage(array $message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @param ModelCriteria $objectManagerQuery
     * @return PageBuilder
     */
    public function setObjectManagerQuery(ModelCriteria $objectManagerQuery)
    {
        $this->objectManagerQuery = $objectManagerQuery;
        return $this;
    }

    /**
     * @return PageInterface
     * @throws \Exception If the type of the page has not been set.
     */
    public function build()
    {
        $this->validateId();

        if ($this->type === null) {
            throw new \Exception("You must set a page type using ::setType before calling this function.");
        }

        if ($this->message !== null) {
            if ($this->type !== Page::PAGE_TYPE_AJAX_ACTION) {
                throw new \Exception("You may only set a message on an ajax-action page.");
            }
        }

        if ($this->type === Page::PAGE_TYPE_AJAX_ACTION) {
            if ($this->message === null) {
                throw new \Exception("You must provide a message for an ajax-action page using ::setMessage");
            }

            foreach ($this->message as $key => $value) {
                $this->message[$key] = htmlentities($value);
            }

            $this->writable = SectionBuilder::begin()
                ->setId("ajax-action-" . $_SERVER["REQUEST_URI"])
                ->addContent(SafeString::fromString(json_encode($this->message)))
                ->build();
        }

        if ($this->type === Page::PAGE_TYPE_OBJECT_MANAGER) {
            if ($this->objectManagerQuery instanceof ModelCriteria === false) {
                throw new \Exception(
                    "For an object manager page, you must provide a Propel query using ::setObjectManagerQuery."
                );
            }

            $page = new ObjectManager(
                $this->id,
                $this->type,
                $this->classes,
                $this->title,
                $this->baseHref,
                $this->header,
                $this->subHeader,
                $this->breadCrumbs,
                $this->returnTo,
                $this->objectManagerQuery
            );

        } else {
            if ($this->objectManagerQuery instanceof ModelCriteria === true) {
                throw new \Exception("You may only provide an object manager query for object manager pages.");
            }

            $page = new Page(
                $this->id,
                $this->type,
                $this->classes,
                $this->title,
                $this->baseHref,
                $this->header,
                $this->subHeader,
                $this->breadCrumbs,
                $this->returnTo,
                $this->writable
            );
        }

        return $page;
    }
}
