<?php

namespace Athens\Core\Admin;

use Exception;

use Propel\Runtime\ActiveQuery\ModelCriteria;

use Athens\Core\Etc\AbstractBuilder;
use Athens\Core\Writable\WritableInterface;
use Athens\Core\Section\SectionBuilder;
use Athens\Core\Etc\SafeString;
use Athens\Core\Page\PageBuilder;
use Athens\Core\Page\PageInterface;
use Athens\Core\Page\Page;

/**
 * Class AdminBuilder
 *
 * @package Athens\Core\Admin
 */
class AdminBuilder extends PageBuilder
{

    /** @var ModelCriteria[] */
    protected $queries = [];

    /** @var {PageInterface|null}[] */
    protected $detailPages = [];

    /**
     * @param WritableInterface $writable
     * @return AdminBuilder
     */
    public function setWritable(WritableInterface $writable)
    {
        $this->writable = $writable;
        return $this;
    }

    /**
     * @param string[] $message
     * @return AdminBuilder
     */
    public function setMessage(array $message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @param ModelCriteria     $objectManagerQuery
     * @param WritableInterface $detailPage
     * @return AdminBuilder
     */
    public function addQuery(ModelCriteria $objectManagerQuery, WritableInterface $detailPage = null)
    {
        $this->queries[] = $objectManagerQuery;
        $this->detailPages[] = $detailPage;

        return $this;
    }

    /**
     * @return PageInterface
     * @throws Exception If the type of the page has not been set.
     */
    public function build()
    {
        $this->validateId();

        if ($this->queries === []) {
            throw new Exception(
                "For an object manager page, you must provide a Propel query(ies) using ::addQuery."
            );
        }
        
        $writable = $this->buildWritableBearer();
        
        $admin = new Admin(
            $this->id,
            $this->type,
            $this->classes,
            $this->title,
            $this->baseHref,
            $this->queries,
            $writable,
            $this->detailPages
        );

        return $admin;
    }
}
