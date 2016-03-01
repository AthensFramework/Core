<?php

namespace Athens\Core\Section;

use Athens\Core\Visitor\VisitableTrait;
use Athens\Core\Writer\WritableInterface;
use Athens\Core\Writer\WritableTrait;

/**
 * A very general display element. May contain other writable elements.
 *
 * @package Athens\Core\Section
 */
class Section implements SectionInterface
{

    /** @var string */
    protected $label;

    /** @var string */
    protected $content;

    /** @var WritableInterface[] */
    protected $writables;

    /** @var callable */
    protected $initFromPost;

    /** @var callable */
    protected $initFromGet;

    /** @var  string */
    protected $type;

    use VisitableTrait;
    use WritableTrait;

    /**
     * Create a new section
     *
     * @param string              $id
     * @param string[]            $classes
     * @param WritableInterface[] $writables
     * @param string              $type
     * @internal param string $content
     * @internal param string $label
     */
    public function __construct($id, array $classes, array $writables, $type)
    {
        $this->id = $id;
        $this->classes = $classes;
        $this->writables = $writables;
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return SectionInterface[]
     */
    public function getWritables()
    {
        return $this->writables;
    }
}
