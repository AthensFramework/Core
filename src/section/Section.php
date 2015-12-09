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


    public function getId()
    {
        return $this->id;
    }

    /**
     * Create a new section
     *
     * @param string              $id
     * @param string              $content
     * @param WritableInterface[] $writables
     * @param string              $label
     * @param $type
     */
    public function __construct($id, $content, array $writables, $label, $type)
    {
        $this->id = $id;
        $this->label = $label;
        $this->content = $content;
        $this->writables = $writables;
        $this->type = $type;
        $this->id = $id;
    }

    /**
     * Return the section's label.
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
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
