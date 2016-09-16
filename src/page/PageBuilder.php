<?php

namespace Athens\Core\Page;

use Exception;

use Athens\Core\Link\LinkBuilder;
use Athens\Core\Writable\AbstractWritableBuilder;
use Athens\Core\Section\SectionBuilder;
use Athens\Core\WritableBearer\WritableBearerBearerBuilderTrait;
use Athens\Core\WritableBearer\WritableBearerBuilder;
use Athens\Core\Visitor\VisitorInterface;
use Athens\Core\Section\SectionInterface;

/**
 * Class PageBuilder
 *
 * @package Athens\Core\Page
 */
class PageBuilder extends AbstractWritableBuilder implements PageConstantsInterface
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
    protected $title;

    /** @var  VisitorInterface */
    protected $initializer;
    
    /** @var  VisitorInterface */
    protected $renderer;

    use WritableBearerBearerBuilderTrait;

    /**
     * @param string $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param string $baseHref
     * @return $this
     */
    public function setBaseHref($baseHref)
    {
        $this->baseHref = $baseHref;
        return $this;
    }

    /**
     * @param string $header
     * @return $this
     */
    public function setHeader($header)
    {
        $this->header = $header;
        return $this;
    }

    /**
     * @param string $subHeader
     * @return $this
     */
    public function setSubHeader($subHeader)
    {
        $this->subHeader = $subHeader;
        return $this;
    }

    /**
     * @param string $title
     * @param string $link
     * @return $this
     */
    public function addBreadCrumb($title, $link = "")
    {
        $this->breadCrumbTitles[] = $title;
        $this->breadCrumbLinks[] = $link;
        
        return $this;
    }

    /**
     * Build the bread crumbs, header, sub header, etc., of the page.
     *
     * @return SectionInterface
     */
    protected function buildTopMatter()
    {
        $topMatterBuilder = SectionBuilder::begin()
            ->setType(SectionBuilder::TYPE_SPAN);

        if ($this->breadCrumbTitles !== []) {
            $breadCrumbsBuilder = SectionBuilder::begin()
                ->setType(SectionBuilder::TYPE_BREADCRUMBS);

            foreach ($this->breadCrumbTitles as $index => $breadCrumbTitle) {
                $breadCrumbLink = $this->breadCrumbLinks[$index];

                if ($breadCrumbLink !== '') {
                    $breadCrumbsBuilder->addWritable(
                        LinkBuilder::begin()->setText($breadCrumbTitle)->setURI($breadCrumbLink)->build()
                    );
                } else {
                    $breadCrumbsBuilder->addContent(
                        $breadCrumbTitle
                    );
                }
            }

            $topMatterBuilder->addWritable($breadCrumbsBuilder->build());
        }

        if ($this->header !== null) {
            $topMatterBuilder->addWritable(
                SectionBuilder::begin()
                    ->setType(SectionBuilder::TYPE_HEADER)
                    ->addLiteralContent($this->header)
                    ->build()
            );
        }

        $topMatterBuilder->addWritable(
            SectionBuilder::begin()
                ->setType(SectionBuilder::TYPE_DIV)
                ->setId('top-filters')
                ->build()
        );

        if ($this->subHeader !== null) {
            $topMatterBuilder->addWritable(
                SectionBuilder::begin()
                    ->setType(SectionBuilder::TYPE_SUBHEADER)
                    ->addLiteralContent($this->subHeader)
                    ->build()
            );
        }

        return $topMatterBuilder->build();
    }

    /**
     * Construct a renderer from setting defaults, if none has been provided.
     *
     * @return void
     */
    protected function validateRenderer()
    {
        if ($this->renderer === null) {
            $settingsInstance = $this->getSettingsInstance();
            
            if ($this->type === static::TYPE_EXCEL) {
                $writerClasses = $settingsInstance->getDefaultExcelWriterClasses();
                $rendererClass = $settingsInstance->getDefaultExcelRendererClass();
            } elseif ($this->type === static::TYPE_PDF) {
                $writerClasses = $settingsInstance->getDefaultPDFWriterClasses();
                $rendererClass = $settingsInstance->getDefaultPDFRendererClass();
            } else {
                $writerClasses = $settingsInstance->getDefaultWriterClasses();
                $rendererClass = $settingsInstance->getDefaultRendererClass();
            }

            $writerInstances = [];
            foreach ($writerClasses as $writerClass) {
                $writerInstances[] = new $writerClass();
            }
            
            $this->renderer = new $rendererClass($writerInstances);
        }
    }

    /**
     * Construct an initializer from setting defaults, if none has been provided.
     *
     * @return void
     */
    protected function validateInitializer()
    {
        if ($this->renderer === null) {
            $settingsInstance = $this->getSettingsInstance();

            if ($this->type === static::TYPE_EXCEL) {
                $initializerClass = $settingsInstance->getDefaultExcelInitializerClass();
            } elseif ($this->type === static::TYPE_PDF) {
                $initializerClass = $settingsInstance->getDefaultPdfInitializerClass();
            } else {
                $initializerClass = $settingsInstance->getDefaultInitializerClass();
            }

            $this->initializer = new $initializerClass;
        }
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

        $this->validateInitializer();
        $this->validateRenderer();

        $writable = WritableBearerBuilder::begin()
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
                            ->build()
                    )
                    ->build()
            )
            ->build();

        return new Page(
            $this->id,
            $this->type,
            $this->classes,
            $this->data,
            $this->title,
            $this->baseHref,
            $this->initializer,
            $this->renderer,
            $writable
        );
    }
}
