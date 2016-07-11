<?php

namespace Athens\Core\Link;

use Athens\Core\Visitor\VisitableTrait;
use Athens\Core\Writable\WritableTrait;

/**
 * Class Link
 * @package Athens\Core\Link
 */
class Link implements LinkInterface
{
    use WritableTrait;

    /** @var string */
    protected $link;
    
    /** @var string  */
    protected $text;

    use VisitableTrait;

    /**
     * Link constructor.
     * @param array  $classes
     * @param array  $data
     * @param string $type
     * @param string $link
     * @param string $text
     */
    public function __construct(
        array $classes,
        array $data,
        $type,
        $link = "",
        $text = ""
    ) {
        $this->type = $type;
        $this->classes = $classes;
        $this->data = $data;

        $this->link = $link;
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getURI()
    {
        return $this->link;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }
}
