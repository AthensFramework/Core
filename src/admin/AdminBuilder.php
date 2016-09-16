<?php

namespace Athens\Core\Admin;

use Exception;

use Propel\Runtime\ActiveQuery\ModelCriteria;

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

    /**
     * @param ModelCriteria     $objectManagerQuery
     * @return $this
     */
    public function addQuery(ModelCriteria $objectManagerQuery)
    {
        $this->queries[] = $objectManagerQuery;

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
            $this->id,
            $this->type,
            $this->classes,
            $this->data,
            $this->title,
            $this->baseHref,
            $this->initializer,
            $this->renderer,
            $pageContents,
            $this->queries
        );

        return $admin;
    }
}
