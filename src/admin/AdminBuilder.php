<?php

namespace Athens\Core\Admin;

use Athens\Core\Visitor\VisitorInterface;
use Exception;

use Propel\Runtime\ActiveQuery\ModelCriteria;

use Athens\Core\Writable\WritableInterface;
use Athens\Core\Section\SectionBuilder;
use Athens\Core\Page\PageBuilder;
use Athens\Core\Page\PageInterface;
use Athens\Core\WritableBearer\WritableBearerBuilder;

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

    /** @var VisitorInterface */
    protected $renderer;

    /**
     * @param VisitorInterface $renderer
     * @return AdminBuilder
     */
    public function setRenderer(VisitorInterface $renderer)
    {
        $this->renderer = $renderer;
        return $this;
    }

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
     * @throws Exception If the a query has not been provided.
     */
    public function build()
    {
        $this->validateInitializer();
        $this->validateRenderer();
        
        if ($this->queries === []) {
            throw new Exception(
                "For an object manager page, you must provide a Propel query(ies) using ::addQuery."
            );
        }

        $pageContents = WritableBearerBuilder::begin()
            ->addWritable(
                SectionBuilder::begin()
                    ->setType(SectionBuilder::TYPE_DIV)
                    ->setId('page-content')
                    ->addWritable(
                        SectionBuilder::begin()
                            ->setType(SectionBuilder::TYPE_DIV)
                            ->setId('page-content-head')
                            ->addWritable($this->buildTopMatter())
                            ->build()
                    )
                    ->addWritable(
                        SectionBuilder::begin()
                            ->setType(SectionBuilder::TYPE_DIV)
                            ->setId('page-content-body')
                            ->addWritable($this->buildWritableBearer())
                            ->addWritable(
                                SectionBuilder::begin()
                                    ->setId('admin-tables-container')
                                    ->build()
                            )
                            ->build()
                    )
                    ->build()
            )
            ->build();
        
        $admin = new Admin(
            $this->id, $this->type, $this->classes, $this->data, $this->title, $this->baseHref, $this->queries, $this->initializer, $this->renderer, $pageContents, $this->detailPages
        );

        return $admin;
    }
}
