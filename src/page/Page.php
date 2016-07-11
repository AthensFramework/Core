<?php

namespace Athens\Core\Page;

use Exception;

use DOMPDF;

use Athens\Core\WritableBearer\WritableBearerBearerTrait;
use Athens\Core\Table\TableInterface;
use Athens\Core\Writable\WritableInterface;
use Athens\Core\Visitor\VisitableTrait;
use Athens\Core\Writer\HTMLWriter;
use Athens\Core\Etc\Settings;
use Athens\Core\Initializer\Initializer;
use Athens\Core\Field\FieldInterface;
use Athens\Core\Writable\WritableTrait;

/**
 * Class Page Provides the primary writable for a page request.
 *
 * @package Athens\Core\Page
 */
class Page implements PageInterface
{
    use VisitableTrait;
    use WritableTrait;
    use WritableBearerBearerTrait;

    /** @var string */
    protected $title;

    /** @var string */
    protected $baseHref;

    /**
     * Page constructor.
     *
     * @param string $id
     * @param string $type
     * @param string[] $classes
     * @param string[] $data
     * @param string $title
     * @param string $baseHref
     * @param WritableInterface|null $writable
     */
    public function __construct(
        $id, $type, array $classes, array $data, $title, $baseHref, WritableInterface $writable = null
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->baseHref = $baseHref;
        $this->writableBearer = $writable;
        $this->type = $type;
        $this->classes = $classes;
        $this->data = $data;
    }
    
    /**
     * Returns the type of the page.
     *
     * This will usually be one of the PageBuilder::TYPE_ consts defined above.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Returns the title of the page.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Returns the baseHref of the page.
     *
     * @return string
     */
    public function getBaseHref()
    {
        return $this->baseHref;
    }

    /**
     * @return Initializer
     */
    protected function makeDefaultInitializer()
    {
        $initializerClass = Settings::getDefaultInitializerClass();
        return new $initializerClass();
    }

    /**
     * @return HTMLWriter
     */
    protected function makeDefaultWriter()
    {
        $writerClass = Settings::getDefaultWriterClass();
        return new $writerClass();
    }
    
    public function render() {
        $this->accept($initializer);
        $renderFunction($this, $writer);
    }
}
