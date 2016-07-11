<?php

namespace Athens\Core\Page;

use Athens\Core\Link\LinkBuilder;
use Athens\Core\Writable\AbstractWritableBuilder;
use Athens\Core\Section\SectionBuilder;
use Athens\Core\WritableBearer\WritableBearerBearerBuilderTrait;
use Athens\Core\WritableBearer\WritableBearerBuilder;
use Athens\Core\Visitor\VisitorInterface;

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
    
    /** @var  VisitorInterface|null */
    protected $renderer;

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

    protected function buildTopMatter()
    {
        $topMatterBuilder = SectionBuilder::begin()
            ->setType(SectionBuilder::TYPE_SPAN);

        if ($this->breadCrumbTitles !== []) {

            $breadCrumbsBuilder = SectionBuilder::begin()
                ->setType(SectionBuilder::TYPE_BREADCRUMBS);

            foreach ($this->breadCrumbTitles as $index => $breadCrumbTitle) {
                $breadCrumbLink = $this->breadCrumbLinks[$index];

                $breadCrumbsBuilder->addWritable(
                    LinkBuilder::begin()->setText($breadCrumbTitle)->setURI($breadCrumbLink)->build()
                );
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

    protected function buildContent()
    {

    }
    
    protected function validateRenderer()
    {
        if ($this->renderer === null) {
            
            $settingsInstance = $this->getSettingsInstance();
            
            if ($this->type === static::TYPE_EXCEL) {
                $initializerClass = $settingsInstance->getDefaultExcelInitializerClass();
                $writerClass = $settingsInstance->getDefaultExcelWriterClass();
                $rendererClass = $settingsInstance->getDefaultExcelRendererClass();
            } elseif ($this->type === static::TYPE_PDF) {
                $initializerClass = $settingsInstance->getDefaultPdfInitializerClass();
                $writerClass = $settingsInstance->getDefaultPdfWriterClass();
                $rendererClass = $settingsInstance->getDefaultPdfRendererClass();
            } else {
                $initializerClass = $settingsInstance->getDefaultInitializerClass();
                $writerClass = $settingsInstance->getDefaultWriterClass();
                $rendererClass = $settingsInstance->getDefaultRendererClass();
            }

            $this->renderer = new $rendererClass(new $initializerClass(), new $writerClass());
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

        $this->validateRenderer();

        $content = $this->buildWritableBearer();

        $writable = WritableBearerBuilder::begin()
            ->addWritable($this->buildTopMatter())
            ->addWritable(
                SectionBuilder::begin()
                    ->setType(SectionBuilder::TYPE_DIV)
                    ->setId('page-content')
                    ->addWritable($content)
                    ->build()
            )
            ->build();

        return new Page($this->id, $this->type, $this->classes, $this->data, $this->title, $this->baseHref, $this->renderer , $writable);
    }
}
