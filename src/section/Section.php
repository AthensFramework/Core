<?php

namespace UWDOEM\Framework\Section;

use UWDOEM\Framework\Visitor\VisitableTrait;
use UWDOEM\Framework\Writer\WritableInterface;

/**
 * A very general display element. May contain other writable elements.
 *
 * @package UWDOEM\Framework\Section
 */
class Section implements SectionInterface
{

    /** @var string */
    protected $id;

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

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Create a new section
     *
     * @param string              $id
     * @param WritableInterface[] $writables
     * @param string              $type
     * @internal param string $content
     * @internal param string $label
     */
    public function __construct($id, array $writables, $type)
    {
        $this->id = $id;
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
